<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /*
     * Authentification 1ere partie
     */
    // Pour pas avoir a redéfinir a chaque fois
    /*public static array $userPrivileges = array(
        'isadmin' => true,
        'issuperadmin' => true,
        'idArticle' => null
    );*/

    #[Route('/create_account', name: 'create_account')]
    public function createAccountAction(EntityManager $em) : Response {
        $authRepository = $em -> getRepository('App:User');
        //$auth = new User();
        $form = $this -> createForm(User::class);
        $form -> add('send',SubmitType::class, ['label' => 'Creer un compte']);

        $args = array('myform' => $form -> createView(), 'myUserPrivileges' => array(
            'isadmin' => true,
            'issuperadmin' => true,
            'idArticle' => null));

        return $this -> render('Form/formAuth.html.twig', $args);
    }
}
