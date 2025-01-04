<?php

namespace App\Controller\Admin\Trait;

use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

trait SearchTrait
{
    //public function __construct( private DcmntRepository  $dcmnts){}
    /**
     * Document search
     */
    #[Route('/search', methods: ['GET'], name: 'search')]
    public function search(Request $request, DcmntRepository $dcmnts): Response
    {
        $query = $request->query->get('q', '');
        $limit = $request->query->get('l', 10);
        
        $fields=[]; 
        foreach(DcmntEntity::FIELDTYPE as $_f=>$_g)
            if($_g == 'string') $fields[$_f] = $_g;

//        if (!$request->isXmlHttpRequest()) {
        if(strlen($query)<3) $foundDcmnts = [];
        else $foundDcmnts = $dcmnts->findBySearchQuery($query, $fields, $limit);

        return $this->render('admin/oooo/search.html.twig', [
            'query' => $query,
            'dcmnts' => $foundDcmnts,
            'fields' => DcmntEntity::FIELDTYPE,
            'llll' => self::llll,
        ]);
    }

    /**
     * Document find
     */
    #[Route('/find', methods: ['GET', 'POST'], name: 'find')]
    public function find(Request $request, DcmntEntity $dcmnt = null, DcmntRepository $dcmnts, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
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
            print_r($crit);
            $dcmnts = $dcmnts->findByLike($crit);
            return $this->render('admin/oooo/list.html.twig', [
                'dcmnts' => $dcmnts,
                'fields' => DcmntEntity::FIELDTYPE,
                'llll' => self::llll,
            ]);
        }

        return $this->render('admin/oooo/find.html.twig', [
            'dcmnt' => $dcmnt ,
            'dcmntForm' => $form->createView(),
            'fields' => $fields,
            'llll' => self::llll,
        ]);
    }
}
