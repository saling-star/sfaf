<?php

namespace App\Controller\Admin;

use App\Entity\User as DcmntEntity;
use App\Entity\User as UlowerEntity;
use App\Entity\User as VlowerEntity;
use App\Form\UsersFormType as DcmntType;
use App\Repository\UsersRepository as DcmntRepository;
//use App\Repository\UsersRepository as UpperURepository;
//use App\Repository\UsersRepository as UpperVRepository;
//use App\Security\UsersVoter as DcmntVoter;
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

#[Route('/admin/users', name: 'admin_users_')]
#[IsGranted('ROLE_ADMIN')]
class UsersController extends AbstractController
{
    const admn = 'admin/'; const admn_ = 'admin_'; const xxxxxx = self::admn_.'users';
    const uupper = self::admn_.'users'; const vupper = self::admn_.'users'; 
    const ulower = self::admn_.'users'; const vlower = self::admn_.'users';
    const llll = [ 'title' => 'User',
    'route_dcmnt_' => self::xxxxxx.'_index',
    'route_dcmnt_list' => self::xxxxxx.'_list',
    'route_dcmnt_id' => self::xxxxxx.'_show',
    'route_dcmnt_paginated' => self::xxxxxx.'_paginated',
    'route_uupper' => self::uupper.'_list',
    'route_uupper_id' => self::uupper.'_show',
    'route_vupper' => self::vupper.'_list',
    'route_vupper_id' => self::vupper.'_show',
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
            'fields' => DcmntEntity::FIELDTYPE,
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
            'fields' => DcmntEntity::FIELDTYPE,
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
        foreach(DcmntEntity::FLDTYPE as $_f=>$_g)
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
     * Document show
     */
    #[Route('/{id<\d+>}', methods: ['GET'], name: 'show')]
    public function show(DcmntEntity $dcmnt): Response
    {
        /* / This security check can also be performed
        // using a PHP attribute: #[IsGranted('show', subject: 'dcmnt', message: 'Documents can only be shown to their authors.')]
        $this->denyAccessUnlessGranted(DcmntVoter::SHOW, $dcmnt, 'Documents can only be shown to their authors.');*/

        return $this->render(self::admn.'oooo/show.html.twig', [
            'dcmnt' => $dcmnt,
            'fields' => DcmntEntity::FIELDTYPE,
            'uflds' => UlowerEntity::FLDTYPE,
            'vflds' => VlowerEntity::FLDTYPE,
            'llll' => self::llll,
        ]);
    }

    /**
     * Creates a new document
     */
    #[Route('/new', methods: ['GET', 'POST'], name: 'new'),
    Route('/{id}/copy', methods: ['GET', 'POST'], name: 'copy')]
    public function new(Request $request, DcmntEntity $dcmnt_o = null, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        if($dcmnt_o === null) $dcmnt = new DcmntEntity();
        else {$dcmnt = clone($dcmnt_o); //$dcmnt->id = 0;
        }
        if(method_exists($dcmnt, "setAuthor"))
            $dcmnt->setAuthor($this->getUser());
        if(method_exists($dcmnt, "setCreatedAt"))
            $dcmnt->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(DcmntType::class, $dcmnt );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(method_exists($dcmnt, "setSlug"))
            {//$title = $dcmnt->getTitle();
                $slug = $slugger->slug($dcmnt->getTitle())->lower();
                $dcmnt->setSlug($slug);
            }
            $entityManager->persist($dcmnt);
            $entityManager->flush();

            $this->addFlash('success', 'document.created_successfully');

            return $this->redirectToRoute(self::xxxxxx.'_show', ['id' => $dcmnt->getId()]);
        }

        return $this->render(self::admn.'oooo/new.html.twig', [
            'dcmnt' => $dcmnt ,
            'dcmntForm' => $form->createView(),
            'fields' => DcmntEntity::FIELDTYPE,
            'llll' => self::llll,
        ]);
    }

    /**
     * Edits a document
     */
    #[Route('/{id<\d+>}/edit', methods: ['GET', 'POST'], name: 'edit')]
    //#[IsGranted('edit', subject: 'dcmnt', message: 'Documents can only be edited by their authors.')]
    public function edit(Request $request, DcmntEntity $dcmnt, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DcmntType::class, $dcmnt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(method_exists($dcmnt, "setSlug"))
            {//$title = $dcmnt->getTitle();
                $slug = $slugger->slug($dcmnt->getTitle())->lower();
                $dcmnt->setSlug($slug);
            }
            if(method_exists($dcmnt, "setAuthor"))
                $dcmnt->setAuthor($this->getUser());
            if(method_exists($dcmnt, "setCreatedAt") && $dcmnt->getCreatedAt()===null)
                $dcmnt->setCreatedAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash('success', 'document.updated_successfully');

            return $this->redirectToRoute(self::xxxxxx.'_show', ['id' => $dcmnt->getId()]);
        }

        return $this->render(self::admn.'oooo/edit.html.twig', [
            'dcmnt' => $dcmnt,
            'dcmntForm' => $form->createView(),
            'fields' => DcmntEntity::FIELDTYPE,
            'llll' => self::llll,
        ]);
    }

    /**
     * Deletes a document
     */
    #[Route('/{id}/delete', methods: ['POST'], name: 'delete')]
    //#[IsGranted('delete', subject: 'dcmnt')]
    public function delete(Request $request, DcmntEntity $dcmnt, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute(self::xxxxxx.'_show', ['id' => $dcmnt->getId()], Response::HTTP_SEE_OTHER);
        }

        $id=$dcmnt->getId();
        $entityManager->remove($dcmnt);
        $entityManager->flush();

        $this->addFlash('success', 'document.deleted_successfully'.' N° '.$id );

        return $this->redirectToRoute(self::xxxxxx.'_list');
    }
}
