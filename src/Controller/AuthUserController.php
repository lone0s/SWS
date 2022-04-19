<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route(
 *  "/auth",
 *  name="auth"
 * )
 */
class AuthUserController extends AbstractController
{
    /**
     * @Route(
     *  "/user/{login}/{password}",
     *  name="_auth"
     * )
     */
    public function connexion($login, $password): Response
    {
        
    }
}
