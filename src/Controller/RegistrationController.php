<?php

namespace App\Controller;

use App\Entity\AuthUser;
use App\Entity\Panier;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new AuthUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //$user -> setPanier($basket);
            $basket = new Panier();
            $userData = $form ->getData();
            $userData -> setPanier($basket);
            $basket -> setUser($userData);
            ///** @var \App\Entity\AuthUser $user */
            //$user = $this -> getUser();
            //$user -> getId();
            //$panier = new Panier();
            //$panier -> setUser($user);
            //$user -> setIdPanier( $panier );
            $entityManager->persist($userData);
            $entityManager->persist($basket);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->render('site/menu.html.twig');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
