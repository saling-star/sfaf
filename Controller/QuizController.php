<?php

namespace App\Controller;

use App\Entity\Qaaa as DcmntEntity;
//use App\Entity\Qbbb as UpperEntity;
use App\Entity\Qccc as UlowerEntity;
use App\Entity\Qddd as ResultEntity;
use App\Entity\Qeee as ReferEntity;
use App\Entity\Qfff as LongContentEntity;
//use App\Form\QbbbType as DcmntType;
use App\Repository\QaaaRepository as DcmntRepository;
use App\Repository\QbbbRepository as UpperRepository;
//use App\Security\QbbbVoter as DcmntVoter;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Mailer\MailerInterface;
//use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
//use Symfony\Component\Security\Http\Attribute\IsGranted;
//use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/quiz')]
class QuizController extends AbstractController
{
    const xxxxxx = 'qaaa'; 
    const llll = [ 'title' => 'Quiz',
        'quiz_index' => 'quiz_index',
    ];

    /**
     * Quiz
     */
    #[Route('/{slug}', methods: ['GET'], name: 'quiz_slug', defaults: ['slug' => 'test'])]
    public function quiz(DcmntEntity $dcmnt): Response
    {
        if($dcmnt->getStatus()=='public_quiz')
            return $this->render('oooo/quiz.html.twig', [
                'dcmnt' => $dcmnt,
                'fields' => DcmntEntity::FIELDTYPE,
            ]);
        else return $this->redirectToRoute('quiz_slug', ['slug' => 'test'], Response::HTTP_SEE_OTHER);
    }

    /**
     * Quiz process
     */
    #[Route('/{slug}/process', methods: ['POST'], name: 'quiz_process')]
    public function quizProcess(Request $request, DcmntEntity $dcmnt, EntityManagerInterface $entityManager, SendMailService $mailService): Response
    {               //print_r($_POST);print_r($request->request->all());
        $quests=[];
        $upperV = $dcmnt->getUpperV();//dcmnt : Qaaa ; upperV : Qbbb
        foreach($upperV->getUlowers() as $ulower){//Ulowers : Qccc
            $quests[$ulower->getNum()] = $ulower;
        }   ksort($quests);//Qbbb->Qccc

        $res_text=''; $e_string='';
        foreach($quests as $quest){ $name=$quest->getName();
            $reqtab = $request->request->all();
            if(in_array($name, array_keys($reqtab)) && $name!='password')
                $res_text .= $name.' : '.$quest->getLabel().' : '.substr($_POST[$name],0,63).'<br />';
            //$_POST[$name] = $reqtab[$name] ???
            if(in_array($name, ['name', 'email', 'title', 'slug']))
                $e_string.=$_POST[$name].'<br>';
        }

        $refer = new ReferEntity();//Qeee
        $refer->setUpperU($dcmnt);//dcmnt : Qaaa
        $refer->setUpuId($dcmnt->getId());//dcmnt : Qaaa_id
        $refer->setStatus($dcmnt->getStatus());//dcmnt : Qaaa_status
        $refer->setEString($e_string);
        $refer->setFString($_SERVER['REMOTE_ADDR']);
        $refer->setGText(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'test');
        $refer->setHText($res_text);
        //$refer->setHText(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'test');
        $refer->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($refer); $entityManager->flush();//Qeee

        foreach($quests as $quest){ $name=$quest->getName();
            $result = new ResultEntity();//Qddd
            $result->setUpperU($quest);
            $result->setUpuId($quest->getId());
            $result->setUpperV($refer);
            $result->setUpvId($refer->getId());
            $result->setNum($quest->getNum());
            $result->setName($name);
            if(in_array($name, array_keys($reqtab))){
                if(strlen($_POST[$name])>235){
                    $long_content = new LongContentEntity();//Qfff
                    $long_content->setLongcontent($_POST[$name]);
                    $entityManager->persist($long_content); 
                    $entityManager->flush();
                    $result->setContent(null);
                    $result->setQfffId($long_content->getId());
                }else{ $result->setContent($_POST[$name]);
                    $result->setQfffId(null);
                }
            }
            $form = $this->createFormBuilder($result)->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($result);
                $entityManager->flush();//Qddd

            }else{ //print_r($_POST);    echo "<br>Error at ".$name."<br>";
                $error_message = $dcmnt->getMessage() .'<br />'. $res_text.
                $this->addFlash('danger', "Error at ".$name);
                return $this->render('oooo/quiz.html.twig', [
                    'dcmnt' => $dcmnt,
                    'fields' => DcmntEntity::FIELDTYPE,
                ]);
            }
        }
        //$eventDispatcher->dispatch(new EntityResponseCreatedEvent($response));
        $success_mes = $dcmnt->getMessage() .'<br />'. $res_text;
        $this->addFlash('success', $success_mes);

        $success_message = $dcmnt->getMessage() .'<br />'. $res_text;
        $trans = "Mail".$mailService->sendMail($dcmnt->getMailFrom(), $dcmnt->getMailTo(), $dcmnt->getTitle(), '', $success_message);

        return $this->render('oooo/quiz_return.html.twig', ['dcmnt' => $dcmnt,'trans' => $trans,]);// 'request'=>$request,]);
        //return $this->redirectToRoute('quiz_slug', ['slug' => $dcmnt->getSlug()]);
    }

    /**
     * Quiz Form
     */
    #[Route('/{slug}/form', methods: ['GET', 'POST'], name: 'quiz_form')]
    #[ParamConverter('dcmnt', options: ['mapping' => ['slug' => 'slug']])]
    public function quizForm(Request $request, DcmntEntity $dcmnt, EntityManagerInterface $entityManager): Response
    {
        $quests=[]; 
        $upperV = $dcmnt->getUpperV();//upperV : Qbbb
        foreach($upperV->getUlowers() as $ulower){//Ulowers : Qccc
            $quests[$ulower->getNum()] = $ulower;
        }   ksort($quests);

        $form = $this->createFormBuilder(new UlowerEntity())->getForm();
        return $this->render('oooo/_questions.html.twig', [
            'dcmnt' => $dcmnt, 'questions' => $quests,
            'form' => $form->createView(),
        ]);
    }
}
