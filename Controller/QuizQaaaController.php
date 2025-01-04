<?php

namespace App\Controller;

use App\Entity\Qaaa as DcmntEntity;
use App\Entity\Qeee as UlowerEntity;
//use App\Entity\Qddd as VlowerEntity;
//use App\Form\QaaaType as DcmntType;
use App\Repository\QaaaRepository as DcmntRepository;
//use App\Repository\QbbbRepository as UpperURepository;
//use App\Repository\QbbbRepository as UpperVRepository;
use App\Repository\QeeeRepository as UlowerRepository;
use App\Repository\QdddRepository as VlowerRepository;
use App\Repository\QfffRepository as LonglowerRepository;
//use App\Security\QaaaVoter as DcmntVoter;
//use App\Service\ImapMailService;
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

#[Route('/quizqaaa', name: 'quizqaaa_')]
#[IsGranted('ROLE_MANAGER')]
class QuizQaaaController extends AbstractController
{
    const admn = ''; const admn_ = ''; const xxxxxx = self::admn_.'quizqaaa';
    const uupper = self::admn_.'qbbb'; const vupper = self::admn_.'qbbb'; 
    const ulower = self::admn_.'qeee'; const vlower = self::admn_.'qddd';
    const llll = [ 'title' => 'Quiz Qaaa',
    'route_dcmnt_' => self::xxxxxx.'_index',
    'route_dcmnt_list' => self::xxxxxx.'_list',
    'route_dcmnt_id' => self::xxxxxx.'_show',
    'route_dcmnt_detail' => 'quiz'.self::ulower.'_show',
    'route_dcmnt_paginated' => self::xxxxxx.'_paginated',
//    'route_uupper' => self::uupper.'_list',
//    'route_uupper_id' => self::uupper.'_show',
//    'route_vupper' => self::vupper.'_list',
//    'route_vupper_id' => self::vupper.'_show',
    'route_ulower_id' => self::ulower.'_show',
    'route_vlower_id' => self::vlower.'_show',
    ];

    /**
     * Document index
     */
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(DcmntRepository $dcmnts): Response
    {
        $dcmnts = $dcmnts->findAll();
        if(count($dcmnts)>99)
            return $this->redirectToRoute(self::xxxxxx.'_group');
        if(count($dcmnts)>29)
            return $this->redirectToRoute(self::xxxxxx.'_last');

        return $this->render(self::admn.'oooo/list.html.twig', [
            'dcmnts' => $dcmnts,
            'flds' => DcmntEntity::FLDTYPE,
            'llll' => self::llll,
        ]);
    }

    /**
     * Document paginated
     */
    #[
        Route('/last', defaults: ['page' => '1'], methods: ['GET'], name: 'last'),
        Route('/page/{page<[1-9]\d*>}', methods: ['GET'], name: 'paginated'),
    ]
    #[Cache(smaxage: 10)]
    public function paginated(Request $request, int $page, DcmntRepository $dcmnts): Response
    {
        $latestDcmnts = $dcmnts->findLatest($page);

        return $this->render(self::admn.'oooo/paginated.html.twig', [
            'paginator' => $latestDcmnts, 
            'flds' => DcmntEntity::FLDTYPE,
            'llll' => self::llll,
        ]);
    }

    #[Route('/group', name: 'group')]
    public function categlog(DcmntRepository $dcmnts): Response
    {
        if(DcmntEntity::FLDG){
        $fields = DcmntEntity::FLDG;
        }
        else return $this->redirectToRoute(self::xxxxxx.'_list');
        $dcmnts = $dcmnts->countByGroupFields($fields);
        $fields['nb']='nb';         //print_r($fields);
        return $this->render(self::admn.'oooo/group.html.twig', [
            'dcmnts' => $dcmnts,
            'flds' => $fields,
            'llll' => self::llll,
        ]);
    }

    #[Route('/subgrp', name: 'subgrp')]
    public function subcateglog(Request $request, DcmntRepository $dcmnts): Response
    {
        $crit=$request->query->all()?$request->query->all()['crit']:[];
        if(DcmntEntity::FLDH){
        $fields = DcmntEntity::FLDH;
        $criteria=[]; //$fields=[];
            foreach($crit as $_x=>$_y){
                if(array_key_exists($_x, DcmntEntity::FIELDTYPE)){
                    $criteria+=[$_x=>$_y];
                    $fields+=[$_x=>DcmntEntity::FIELDTYPE[$_x]];
                }
            } 
        }
        else return $this->redirectToRoute(self::xxxxxx.'_list');
        $dcmnts = $dcmnts->countByGroupFields($fields, $criteria);
        $fields['nb']='nb';         //print_r($fields);
        return $this->render(self::admn.'oooo/group.html.twig', [
            'dcmnts' => $dcmnts,
            'flds' => $fields,
            'llll' => self::llll,
        ]);
    }

    /**
     * Document list
     */
    #[Route('/list', methods: ['GET', 'POST'], name: 'list')]
    public function list(Request $request, DcmntRepository $dcmnts): Response
    {
        $criteria_=$request->query->all()?$request->query->all()['dcmnt']:[];
        if($criteria_ == []) 
            return $this->redirectToRoute(self::xxxxxx.'_index');
        elseif(null !== $request->query->get('id')){ $id = $request->query->get('id');
            return $this->redirectToRoute(self::xxxxxx.'_show', ['id' => $id]);
        }else{ $criteria=[]; $fields=[];
            foreach($criteria_ as $_x=>$_y){
                if(array_key_exists($_x, DcmntEntity::FIELDTYPE)){
                    $criteria+=[$_x=>$_y];
                    $fields+=[$_x=>DcmntEntity::FIELDTYPE[$_x]];
                }
            } 
            if(is_array(DcmntEntity::FLDH))
                if($criteria_['nb']>11 && count($criteria) != count(DcmntEntity::FLDH))
                    return $this->redirectToRoute(self::xxxxxx.'_subgrp', ['crit' => $criteria]);
            $dcmnts =$dcmnts->findBy($criteria);
        }

        return $this->render(self::admn.'oooo/list.html.twig', [
            'dcmnts' => $dcmnts,
            'flds' => DcmntEntity::FLDTYPE,
            'llll' => self::llll,
        ]);
    }

    /**
     * Document search
     */
    #[Route('/search', methods: ['GET'], name: 'search')]
    public function search(Request $request, DcmntRepository $dcmnts): Response
    {
        $query = $request->query->get('q', '');
        $limit = $request->query->get('l', 100);
        
        $fields=[]; 
        foreach(DcmntEntity::FLDTYPE as $_f=>$_g)
            if($_g == 'string') $fields[$_f] = $_g;

//        if (!$request->isXmlHttpRequest()) {
        if(strlen($query)<3) $foundDcmnts = [];
        else $foundDcmnts = $dcmnts->findBySearchQuery($query, $fields, $limit);

        return $this->render(self::admn.'oooo/search.html.twig', [
            'query' => $query,
            'dcmnts' => $foundDcmnts,
            'flds' => DcmntEntity::FLDTYPE,
            'llll' => self::llll,
        ]);
    }

    /**
     * Document find
     */
    #[Route('/find', methods: ['GET', 'POST'], name: 'find')]
    public function find(Request $request, DcmntEntity $dcmnt = null, DcmntRepository $dcmnts): Response
    {
        $dcmnt = new DcmntEntity();
        $fields=[]; 
        foreach(DcmntEntity::FIELDTYPE as $_f=>$_g)
            if($_g == 'string') $fields[$_f] = $_g;

        $find_form = $this->createFormBuilder($dcmnt);
        foreach($fields as $_f=>$_g)
            $find_form->add($_f);//, TextareaType::class, ['required' => false,]
        $form = $find_form->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $crit=[]; 
            foreach($fields as $_f=>$_g)
                if($dcmnt->{'get'.ucfirst($_f)}()) 
                    $crit[$_f]=$dcmnt->{'get'.ucfirst($_f)}();
            //print_r($crit);
            $dcmnts = $dcmnts->findByLike($crit);
            return $this->render(self::admn.'oooo/list.html.twig', [
                'dcmnts' => $dcmnts, 'crit' => $crit,
                'flds' => DcmntEntity::FLDTYPE,
                'llll' => self::llll,
            ]);
        }

        return $this->render(self::admn.'oooo/find.html.twig', [
            'dcmnt' => $dcmnt ,
            'dcmntForm' => $form->createView(),
            'fields' => $fields,
            'llll' => self::llll,
        ]);
    }

    /**
     * Document show Qaaa + Qeee list
     */
    #[Route('/{id<\d+>}', methods: ['GET'], name: 'show')]
    public function show(DcmntEntity $dcmnt, UlowerRepository $lowers): Response
    {
        if(null!==$dcmnt->getUlowers()) $lowers=$lowers->findByLike(['upuId'=>$dcmnt->getId()]); //Qeee

        return $this->render(self::admn.'oooo/show.html.twig', [
            'dcmnt' => $dcmnt,'lowers' => $lowers, //lowers : Qeee
            'fields' => DcmntEntity::FIELDTYPE,
            'uflds' => UlowerEntity::FIELDTYPE,
            //'vflds' => VlowerEntity::FIELDTYPE,
            'llll' => self::llll,
        ]);
    }
}
