<?php

namespace App\Controller;

use App\Entity\Wwww as DcmntEntity;
use App\Entity\Wwww as UlowerEntity;
use App\Entity\Wwww as VlowerEntity;
use App\Form\WwwwType as DcmntType;
use App\Repository\WwwwRepository as DcmntRepository;
//use App\Repository\WwwwRepository as UpperURepository;
//use App\Repository\WwwwRepository as UpperVRepository;
//use App\Security\WwwwVoter as DcmntVoter;
use App\Service\ImapMailService;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Mailer\MailerInterface;
//use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
//use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/wwww', name: 'wwww_')]
#[IsGranted('ROLE_MANAGER')]
class WwwwController extends AbstractController
{
    const admn = ''; const admn_ = ''; const xxxxxx = self::admn_.'wwww';
    const uupper = self::admn_.'wwww'; const vupper = self::admn_.'wwww'; 
    const ulower = self::admn_.'wwww'; const vlower = self::admn_.'wwww';
    const llll = [ 'title' => 'Mail',
    'route_dcmnt_' => self::xxxxxx.'_index',
    'route_dcmnt_list' => self::xxxxxx.'_list',
    'route_dcmnt_id' => self::xxxxxx.'_show',
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
    public function index(Request $request, DcmntRepository $dcmnts): Response
    {
        //$dcmnts = $dcmnts->findAll();
        $crit = self::status_select($request);
        $dcmnts = $dcmnts->findByLike($crit);
        return $this->render(self::admn.'oooo/list.html.twig', [
            'dcmnts' => $dcmnts,
            'flds' => DcmntEntity::FLDTYPE,
            'llll' => self::llll,
        ]);
    }

    #[Route('/group', name: 'group')]
    public function categlog(Request $request, DcmntRepository $dcmnts): Response
    {
        if(DcmntEntity::FLDG){ $fields = DcmntEntity::FLDG;}
        else return $this->redirectToRoute(self::xxxxxx.'_list');
        $crit = self::status_select($request);
        $dcmnts = $dcmnts->countByGroupFields($fields, $crit);
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
        $crit += self::status_select($request);
        if(DcmntEntity::FLDH){
        $fields = DcmntEntity::FLDH;
        $criteria = self::status_select($request);//[]; $fields=[];
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
        }else{ $fields=[];$criteria = self::status_select($request);
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
     * Document show
     */
    #[Route('/{id<\d+>}', methods: ['GET'], name: 'show')]
    public function show(DcmntEntity $dcmnt, ImapMailService $mailService, EntityManagerInterface $entityManager): Response
    {
        self::mail_extra($dcmnt, $mailService, $entityManager);

        return $this->render(self::admn.'oooo/showw.html.twig', [
            'dcmnt' => $dcmnt,
            'fields' => DcmntEntity::FLDTYPE,//password   in FIELDTYPE
            'uflds' => UlowerEntity::FLDTYPE,//password not in FLDTYPE
            'vflds' => VlowerEntity::FLDTYPE,
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

    #[Route('/mail', methods: ['GET'], name: 'mail')]
    public function mail(Request $request, DcmntRepository $dcmnts, ImapMailService $mailService, EntityManagerInterface $entityManager): Response
    {
        $crit = self::status_select($request);
        $dcmnts = $dcmnts->findByLike($crit);
        foreach($dcmnts as $dcmnt){
            self::mail_extra($dcmnt, $mailService, $entityManager);
        }

        return $this->render(self::admn.'oooo/list.html.twig', [
            'dcmnts' => $dcmnts,
            'fields' => DcmntEntity::FLDTYPE,
            'llll' => self::llll,
        ]);
    }

    private function mail_extra($dcmnt, ImapMailService $mailService, EntityManagerInterface $entityManager):void
    {
        if($dcmnt->getFai()!=''){
            $now=new \DateTimeImmutable();
            $now_=$now->format('Y-m-d H:i:s');
            $extra = self::mail_stat($dcmnt, $mailService);
            if(isset($extra['unseen'])&&$extra['unseen']>0){
                $text_=$now_.' = '.$extra['text'];
                if(strlen($text_)>4000)
                    $text_=strlen($text_).substr($text_,0,4000);
                $dcmnt->setExtra($text_);
            }else $dcmnt->setExtra(substr($dcmnt->getExtra(),0,20));
            //$entityManager->persist($dcmnt);
            $entityManager->flush();
        }
    }

    private function mail_stat($dcmnt, ImapMailService $mailService):array
    {
        if(null !==$dcmnt->getFai()){
            $fai=$dcmnt->getFai(); $nnn=$dcmnt->getNnn();
            if($fai=='gmail.com') return [];
            elseif($dcmnt->getCateg()=='netinter'){
                $mailBox='{rosette.o2switch.net:993/imap/ssl}INBOX';
                $mailAdr=$nnn.'@'.$fai;
            }elseif($fai=='free.fr'){
                $mailBox='{imap.free.fr:993/imap/ssl}INBOX';
                $mailAdr=$nnn.'@'.$fai;
            }elseif($fai=='laposte.net'){
                $mailBox='{imap.laposte.net:993/imap/ssl}INBOX';
                $mailAdr=$nnn.'@'.$fai;
            }elseif($fai=='gmail.com'){
                $mailBox='{imap.gmail.com:993/imap/ssl}INBOX';
                $mailAdr=$nnn.'@'.$fai;
            }else{ $mailBox='{imap.'.$fai.':993/imap/ssl}INBOX';
                $mailAdr=$nnn.'@'.$fai;
            }
            $extra = $mailService->imapMail($mailBox,$mailAdr,$dcmnt->getPpp());
        }else $extra=[];
        return $extra;
    }

    private function status_select(Request $request):array
    {
        //URI : /wwww/mail?usid=0, 1, 2... => uid=0, 1, 2...
        if(array_key_exists('usid', $request->query->all()))
            $usid=$request->query->all()['usid'];
        else $usid='';
        $userId = $this->getUser()->getId();
        if($userId==1 && $usid!='') $uid=$usid;
        else $uid=$userId;
        if($uid=='e') $crit = ['extra'=>'%@%'];
        else $crit = ['status' => '%='.$uid.'=%'];   //print_r($crit);
        return $crit;
    }
}
