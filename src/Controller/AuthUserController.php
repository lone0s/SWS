<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/auth', name: 'auth')]
class AuthUserController extends AbstractController
{
    #[Route('/user', name: '_user')]
    public function index(): Response
    {
        return $this->render('auth_user/index.html.twig', [
            'controller_name' => 'AuthUserController',
        ]);
    }
}
