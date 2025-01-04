<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurWPController extends AbstractController
{
    #[Route(path: '/wp-login.php', name: 'wp_login')]
    public function login(): Response
    {

        // get the login error if there is one
        $error = "Bad credentials";
        // last username entered by the user
        $lastUsername = '';

        return $this->render('security/wp-login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
