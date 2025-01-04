<?php   // src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        // $this->session = $requestStack->getSession();
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $env = $_ENV['APP_ENV'];
        $addr = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'';
        $session = $this->requestStack->getSession();
        $sleep_time=$session->get('sleep_time', 10);
        $last_addr=$session->get('last_addr', '');//echo $last_addr;
        if($addr == $last_addr) $sleep_time +=10;
        else $session->set('last_addr', $addr);
        if($env == "dev") $sleep_time=0;
        else $session->set('sleep_time', $sleep_time);
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $message = sprintf(
            'Exception Error : %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        ); //$message = "Page not available : <a href='/'>Homepage</a>";

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent($message);

        $uri=$_SERVER['REQUEST_URI'];$needle="wp-login.php";
            if(stripos($uri, $needle)){
                header("Location: https://sfaj.netinter.fr/wp-login.php");die();
            }
        foreach(['.env','wp-includes','wp-content','wp-admin', ] as $needle){
            if(stripos($uri, $needle)){
                header("Location: http://waxkyz.free.fr");die();
            }
        }
        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        /*if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else */{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);//HTTP_INTERNAL_SERVER_ERROR);
        }
        $_SERVER['SERVER_ERROR'] = '11111'; sleep($sleep_time);
        // sends the modified response object to the event
        //if($env == "prod")
            //$event->setResponse($response);
    }
}
