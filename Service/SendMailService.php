<?php // src/App/Service/SendMailService.php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(string $mail_from='', string $mail_to='', string $subject='', string $text='', string $html='')
    {
        if($mail_from=='') $mail_from = 'admin@netinter.fr';
        if($mail_to=='') $mail_to = 'contact@netinter.fr';
        if($subject=='') $subject = 'Test';
        if($text=='') $text = 'Test (text)';
        if($html=='') $text = 'Test (html)';
        $mail = (new Email());
        $mail->from($mail_from);
        $mail->to($mail_to);
        $mail->cc('log@netinter.fr');
        //$mail->bcc('log@netinter.fr');
        //$mail->replyTo('admin@netinter.fr');
        //$mail->priority(Email::PRIORITY_HIGH);
        $mail->subject($subject);
        $mail->text($text);
        $mail->html($html);
        //try { 
        return $this->mailer->send($mail);//var_dump($mail);
        /*} catch (\Exception $e) {
        return new JsonResponse(['message' => 'An error occurred while sending the email: ' . $e->getMessage()]);
        }*/
    }
}
