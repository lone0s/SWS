<?php

namespace App\Controller;

use App\Entity\AuthUser;
use App\Form\AccountCreatorType2;
use App\Form\AuthentificationForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Route(
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
    /*public function connexion($login, $password): Response
    {
        
    }*/
    #[Route('/create_account', name: '_createaccountApp')]

    public function createAccountAction(ManagerRegistry $doc, Request $request) : Response {
        $em = $doc -> getManager();
        $newUser = new AuthUser();
        $form = $this -> createForm(AccountCreatorType2::class,$newUser);
        $form -> add("send", SubmitType::class, ['label' => "Creer mon compte"]);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form -> isValid()) {
            $newUser = $form->getData();
            $newUser -> setRoles(['ROLE_USER']);
            $em->persist($newUser);
            $em->flush();
            $this->addFlash('info', "Creation d'un compte réussi");
            //return $this->redirectToRoute("_get_products");
        }
        if ($form -> isSubmitted()) {
            $this -> addFlash('info', "Erreur creation compte, contenu incomplet/invalide");
        }
        $args = array("formulaire" => $form->createView());
        return $this -> render("Form/articleForm.html.twig",$args);
    }

    #[Route('/connect', name: '_connectToAccount')]
    public function connectAction(ManagerRegistry $doc, Request $request) : Response {
        $em = $doc -> getManager();
        //$form = $this -> createForm(AuthentificationForm::class,$newUser);
        //$form -> add("send", SubmitType::class, ['label' => "Me Connecter"]);
        //$form -> handleRequest($request);
        //if ($form->isSubmitted() && $form -> isValid()) {
            /*$newUser = $form->getData();
            $em->persist($newUser);
            $em->flush();
            $this->addFlash('info', "Creation d'un compte réussi");
            return $this->redirectToRoute("_get_products");*/
            //$user = $form -> getData();
           // $username = $user -> get
        //}
        //if ($form -> isSubmitted()) {
         //   $this -> addFlash('info', "Erreur creation compte, contenu incomplet/invalide");
        //}
        //$args = array("formulaire" => $form->createView());
        return $this -> render("Form/articleForm.html.twig");
    }
}
