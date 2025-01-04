<?php

namespace App\Repository;

use App\Entity\Xxxx as Entity;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\String\u;

class XxxxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }

    public function findLatest(int $page = 1): Paginator
    {
        $qb = $this->createQueryBuilder('x')
            ->orderBy('x.id', 'DESC')
        ;
        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @return Entity[]
     */
    public function countByGroupFields(array $fields, array $crit=[]): array
    {
        if($fields===[]) return $fields;
        $group='';
        foreach($fields as $_x=>$_y){ $group.="x.{$_x} ,";}
        $group = substr($group,0,strlen($group)-1);
        $result = $this->createQueryBuilder('x')
            ->select("$group ,COUNT(x.id) nb")
            ->groupBy("$group")
            ->orderBy("$group")
            ->getQuery()
            ->getResult()
        ;
        if($crit!==[]){ $criter='';
            $result = $this->createQueryBuilder('x')
                ->select("$group ,COUNT(x.id) nb");
            foreach($crit as $_x=>$_y){ 
            $result = $result->andWhere("x.$_x LIKE '$_y'");}
            $result = $result->groupBy("$group")
                ->orderBy("$group")
                ->getQuery()
                ->getResult()
            ;
        }
        return $result;
    }

    /**
     * @return Entity[]
     */
    public function findByLike($criteria, string $num_eq = '='): array
    {
        if($criteria===[]) return [];
        $result = $this->createQueryBuilder('x');
        foreach($criteria as $_x=>$_y){ 
            if(is_numeric($_y)) $result->andWhere("x.$_x $num_eq $_y" );
            else if(is_string($_y)&& trim($_y)!='') 
                $result->andWhere("x.$_x LIKE '$_y'" );}
        return $result->orderBy('x.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Entity[]
     */
    public function findBySearchQuery(string $query, array $fields, int $limit = Paginator::PAGE_SIZE): array
    {
        $searchTerms = $this->extractSearchTerms($query);

        if (0 === \count($searchTerms)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('x');

        foreach ($searchTerms as $key => $term) {
        foreach ($fields as $_x=>$_y) {
            $queryBuilder
                ->orWhere('x.'.$_x.' LIKE :t_'.$key)
                ->setParameter('t_'.$key, '%'.$term.'%')
            ;
        }
        }

        return $queryBuilder
            ->orderBy('x.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Transforms the search string into an array of search terms.
     */
    private function extractSearchTerms(string $searchQuery): array
    {
        $searchQuery = u($searchQuery)->replaceMatches('/[[:space:]]+/', ' ')->trim();
        $terms = array_unique($searchQuery->split(' '));

        // ignore the search terms that are too short
        return array_filter($terms, static function ($term) {
            return 2 <= $term->length();
        });
    }

    // /**
    //  * @return Entity[] Returns an array of Entity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('x.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entity
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
