<?php // src/App/Service/SendMailService.php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ImapMailService
{
    public function imapMail(string $mailBox, string $mailAdr, string $ppp=''):array
    {
        /* Connecting FAI server with IMAP */
        try{$connection = imap_open($mailBox, $mailAdr, $ppp);}
        catch (\Exception $e) { 
            return ['text'=>"*** Error $mailAdr ***",'unseen'=>"9999"];//$mailAdr,$e->getMessage(),imap_last_error()];
        }// or die('Error: ' .$mailAdr. imap_last_error());
        if($connection){
            if($stat = imap_status($connection, $mailBox, SA_ALL))
            {
                $out['messages']=$stat->messages;
                $out['recent']=$stat->recent;
                $out['unseen']=$stat->unseen;
                $out['text']='<font color=green> '.$mailAdr.'</font>
                Messages : '.$stat->messages.'
                <font color=blue>Récents : '.$stat->recent.'</font>
                <font color=red>Non lus : '.$stat->unseen.'</font>';
            }else{ $out['text']="No results";$out['messages']=''; $out['recent']='';$out['unseen']='';}
if($out['unseen']>0){
    $msg_search=imap_search ($connection, 'UNSEEN');
    if($msg_search < 1){$msg_empty = "No New Messages";}
    else {
        rsort($msg_search);
        foreach ($msg_search as $msg_nb) {
            $headerinfo = imap_headerinfo($connection, $msg_nb);
            if(property_exists($headerinfo,'Subject')){
                $sub=substr($headerinfo->Subject,0,8);//echo $sub;
                if($sub=='=?utf-8?'){
                    $dec=$headerinfo->Subject;//$subject = $dec;
                    $subject = iconv_mime_decode($dec, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, 'UTF-8');
                } else $subject = $headerinfo->Subject;
            }else $subject = '';
            //Then spit it out below.........if you dont swallow
            $out['text'] .= "<hr />Message ID# " . $msg_nb . "
            Date: " . date("F j, Y, g:i a", $headerinfo->udate) . "
            From: " . $headerinfo->fromaddress . "
            <br />Subject: " . $subject;
        }
    }
}
            imap_close($connection);
            return $out;
        }
    }
}
