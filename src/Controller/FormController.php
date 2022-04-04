<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/create_account', name: 'create_account')]
    public function createAccountAction() : Response {
        return $this -> render("/form/index.html.twig");
    }
}
