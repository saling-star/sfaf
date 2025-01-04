<?php   // src/EventSubscriber/VisitSubscriber.php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\Visit;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
//use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VisitSubscriber implements EventSubscriberInterface
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ResponseEvent::class => 'onKernelResponse',
        ];
    }

    private static function selector($strname): string
    {//false !== strpos : case strpos = 0 (!= false)
if($strname=='/') return('/');
elseif($strname=='/fr/') return('fr');
elseif($strname=='/en/') return('en');
elseif($strname=='/es/') return('es');
elseif(false !== strpos($strname,'page',0)) return('page');
elseif(false !== strpos($strname,'post',0)) return('post');
elseif(false !== strpos(strtolower($strname),'article',0)) return('article');
elseif(false !== strpos(strtolower($strname),'comment',0)) return('comment');
//elseif(false !== strpos(strtolower($strname),'node',0)) return('node');
//elseif(false !== strpos(strtolower($strname),'note',0)) return('note');
elseif(false !== strpos(strtolower($strname),'entr',0)) return('entry');
elseif(false !== strpos(strtolower($strname),'quiz',0)) return('quiz');
elseif(false !== strpos(strtolower($strname),'search',0)) return('search');
elseif(false !== strpos(strtolower($strname),'sitemap',0)) return('sitemap');
elseif(false !== strpos(strtolower($strname),'wp-login',0)) return('wp-login');
//elseif(false !== strpos(strtolower($strname),'_wdt',0)) return('_wdt');
else return('xxxxx');
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if(!$event->isMainRequest()) return;

        $visit = new Visit();
        $visit->setRoot(isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:'');
        $visit->setUri(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'');
        $visit->setQuery(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'');
        $visit->setReferer(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'');
        $visit->setUserAgent(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'');
        $visit->setCookie(isset($_SERVER['HTTP_COOKIE'])?$_SERVER['HTTP_COOKIE']:'');
        $visit->setAddr(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'');
        if($this->tokenStorage->getToken()){
            $user = $this->tokenStorage->getToken()->getUser();
            $visit->setName($user->getId().' : '.$user->getDisplayName());
        }else{if(isset($_SERVER['SERVER_ERROR']))
                $visit->setName($_SERVER['SERVER_ERROR']);
        else    $visit->setName($this->selector($_SERVER['REQUEST_URI']));
        }//$visit->setName(isset($_SERVER['APP_NAME'])?$_SERVER['APP_NAME']:'');
        $visit->setCreatedAt(new DateTimeImmutable('now'));//sfax (Symfony)
        //$visit->setVisitDate(new DateTimeImmutable('now'));//sfbx (Bolt)
        $visit->setDelay(time()-$_SERVER['REQUEST_TIME']);
        {
            $em = $this->doctrine->getManager();
            $em->persist($visit);
            $em->flush();
        }
        return true;
    }
}
