<?php

namespace App\Controller;

use App\Entity\Aacb as DcmntEntity;
use App\Entity\Aacb as TlowerEntity;
use App\Entity\Abbb as UlowerEntity;
use App\Entity\Abbb as VlowerEntity;
//use App\Form\AacbType as DcmntType;
use App\Repository\AacbRepository as DcmntRepository;
//use App\Repository\AacbRepository as UpperTRepository;
//use App\Repository\AbbbRepository as UpperURepository;
//use App\Repository\AbbbRepository as UpperVRepository;
use App\Repository\AacbRepository as LowerTRepository;
use App\Repository\AbbbRepository as LowerURepository;
use App\Repository\AbbbRepository as LowerVRepository;
//use App\Security\AacbVoter as DcmntVoter;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/compta', name: 'compta_')]
#[IsGranted('ROLE_MANAGER')]
class ComptaController extends AbstractController
{
    const xxxxxx = 'aacb'; const upperT = 'aacb';
    const uupper = 'aacb'; const vupper = 'aacb';
    const tlower = 'aacb'; const ulower = 'abbb'; const vlower = 'abbb';
    const llll = [ 'title' => 'Compta',
    'route_uppert' => 'admin_'.self::upperT.'_list',
//    'route_tupper_id' => 'admin_'.self::upperT.'_show',
    'route_uupper' => 'admin_'.self::uupper.'_list',
    'route_uupper_id' => 'admin_'.self::uupper.'_show',
    'route_vupper' => 'admin_'.self::vupper.'_list',
    'route_vupper_id' => 'admin_'.self::vupper.'_show',
    'route_dcmnt_' => 'admin_'.self::xxxxxx.'_list',
    'route_dcmnt_id' => 'admin_'.self::xxxxxx.'_show',
    'route_tlower_id' => 'admin_'.self::tlower.'_show',
    'route_ulower_id' => self::ulower.'_show',
    'route_vlower_id' => self::vlower.'_show',
    ];

    /**
     * Compta
     */
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(): Response
    {
        return $this->render('compta/index.html.twig', [
            'llll' => self::llll,
        ]);
    }

    /**
     * Bilan
     */
    #[Route('/bilan', methods: ['GET'], name: 'bilan')]
    public function bilan(DcmntRepository $dcmnts, LowerTRepository $tlowers, LowerURepository $ulowers, LowerVRepository $vlowers, Request $request): Response
    {
        $crit['dir'] = $request->query->get('dir');
        $crit['year'] = $request->query->get('year');
        $crit_d['dir'] = $crit['dir'].'%';
        $crit_e['year = '] = $crit['year'];
        $crit_l['year <= '] = $crit['year'];
        $dcmnts = $dcmnts->findAll(); //$dcs = clone $dcmnts;
        $dcs = self::accounts($crit_d, $crit_e, $crit_l, $dcmnts, $tlowers, $ulowers, $vlowers);
        $result=[]; $sum1=0; $sum2=0; $sum6=0; $sum7=0;
        foreach($dcs as $dc)
        {
            $result[$dc->getId()] = $dc->getSumT()/100;
            if(substr($dc->getCode(),0,1)==7)$sum7+=$dc->getSumT()/100;
            elseif(substr($dc->getCode(),0,1)==6)$sum6+=$dc->getSumT()/100;
            elseif(substr($dc->getCode(),0,1)==1)$sum1+=$dc->getSumT()/100;
            else $sum2+=$dc->getSumT()/100; //2, 3, 4 : actif
        }
        $result[7] = $sum7; $result[6] = $sum6;
        $result[2] = $sum2; $result[1] = $sum1;

        return $this->render('compta/bilan.html.twig', [
            'result' => $result,'dcs' => $dcs,
            'fields' => DcmntEntity::FIELDTYPE,
            'llll' => self::llll,'crit'=>$crit,
        ]);
    }

    /**
     * Document show
     */
    #[Route('/{id<\d+>}', methods: ['GET'], name: 'show')]
    public function show(DcmntEntity $dcmnt, LowerTRepository $tlowers, LowerURepository $ulowers, LowerVRepository $vlowers, Request $request): Response
    {
        $crit['dir'] = $request->query->get('dir'); $dir_ = $crit['dir'].'%';
        $crit['year'] = $request->query->get('year'); $year_ = $crit['year'].'%';
        $crit_d['dir'] = $crit['dir'].'%';
        $crit_e['year = '] = $crit['year'];
        $crit_l['year <= '] = $crit['year'];
        $code = substr($dcmnt->getCode(),0,1);

        $tlowers = $tlowers->findByLike(['uptSlug' => $dcmnt->getSlug()]);
        $sum_t=0; foreach($tlowers as $lower) $sum_t += $lower->getSumT();

        if($code==6 || $code==7) 
        $ulowers = $ulowers->findByLike(['upuSlug' => $dcmnt->getSlug(), 'dir' => $dir_, 'year' => $year_]);
        else $ulowers = $ulowers->findByLike(['upuSlug' => $dcmnt->getSlug(), 'dir' => $dir_]);
        $sum_u=0; foreach($ulowers as $lower) $sum_u += $lower->getValue();

        if($code==6 || $code==7) 
        $vlowers = $vlowers->findByLike(['upvSlug' => $dcmnt->getSlug(), 'dir' => $dir_, 'year' => $year_]);
        else $vlowers = $vlowers->findByLike(['upvSlug' => $dcmnt->getSlug(), 'dir' => $dir_]);
        $sum_v=0; foreach($vlowers as $lower) $sum_v += $lower->getValue();

        return $this->render('compta/show.html.twig', [
            'dcmnt' => $dcmnt, 
            'tlowers' => $tlowers, 'sum_t' => $sum_t,
            'ulowers' => $ulowers, 'sum_u' => $sum_u,
            'vlowers' => $vlowers, 'sum_v' => $sum_v,
            'fields' => DcmntEntity::FIELDTYPE,
            'tflds' => DcmntEntity::FIELDTYPE,
            'uflds' => UlowerEntity::FIELDTYPE,
            'vflds' => VlowerEntity::FIELDTYPE,
            'llll' => self::llll,'crit'=>$crit,
        ]);
    }

    private function accounts(array $crit_d, array $crit_e, array $crit_l, array $dcmnts, LowerTRepository $tlowers, LowerURepository $ulowers, LowerVRepository $vlowers): array
    {
        foreach($dcmnts as $dcmnt){
            self::accsums($crit_d, $crit_e, $crit_l, $dcmnt, $ulowers, $vlowers);
        }
        $dcs = [];
        foreach($dcmnts as $dcmnt)
        if($dcmnt->getUptSlug()==''){ $dc = clone $dcmnt;
            $lowers = $tlowers->findByLike(['uptSlug' => $dcmnt->getSlug()]);
            $sum_t=0;
            foreach($lowers as $lower) $sum_t += $lower->getSumT();
            $dc->setSumT($sum_t);
            $dcs[$dc->getId()] = $dc;
        }
        return $dcs;
    }

    private function accsums(array $crit_d, array $crit_e, array $crit_l, $dcmnt, LowerURepository $ulowers, LowerVRepository $vlowers)
    {
        $code = substr($dcmnt->getCode(),0,1);
        if($code==6 || $code==7) $crit_el = $crit_e; 
        else $crit_el = $crit_l;
        
        $crit_u = array_merge($crit_d,$crit_el,['upuSlug' => $dcmnt->getSlug()]);
        $lowers = $ulowers->findByLike($crit_u, '');
        $sum_u=0;
        foreach($lowers as $lower) $sum_u += 100*$lower->getValue();
        $dcmnt->setSumU($sum_u );
        
        $crit_v = array_merge($crit_d,$crit_el,['upvSlug' => $dcmnt->getSlug()]);
        $lowers = $vlowers->findByLike($crit_v, '');
        $sum_v=0;
        foreach($lowers as $lower) $sum_v +=  100*$lower->getValue();
        $dcmnt->setSumV($sum_v );
        
        $dcmnt->setSumT($sum_u - $sum_v );
    }
}
