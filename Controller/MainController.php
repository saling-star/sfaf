<?php

namespace App\Controller;

#use App\Service\ImapMailService;
use App\Service\SendMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #use ContactTrait;
    
    #[Route('/', name: 'main')]
    public function main(Request $request): Response
    {

        return $this->render('main/index.html.twig', []);
    }

    #[Route('/main', name: 'app_main')]
    public function index(Request $request): Response
    {
        $this->addFlash('success', 'Welcome');

        return $this->render('main/main.html.twig', [
            'request' => $request,
        ]);
    }

   #[Route("/mail_test", name: "mail_test")]
   public function sendMail(SendMailService $mailService, MailerInterface $mailer)
   {
        $mail = $mailService->sendMail('', 'contact@netinter.fr', 'title', 'text content', 'html content');
        $this->addFlash('notification', 'mail send '.$mail);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'mail' => $mail,
        ]);
      return $this->redirectToRoute('app_main');
   }
}
