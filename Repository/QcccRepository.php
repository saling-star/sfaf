<?php

namespace App\Repository;

use App\Entity\Qccc as Entity;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\String\u;

class QcccRepository extends XxxxRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        //parent::__construct($registry, Entity::class);
        ServiceEntityRepository::__construct($registry, Entity::class);
    }
}
