<?php

namespace App\Controller;

use App\Form\EditProfilType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app', name: 'app')]
class ProfileController extends AbstractController
{
    #[Route('/editprofile', name: '_edit_profile')]
    public function editProfileAction(ManagerRegistry $doc, Request $request): Response
    {
        $em = $doc->getManager();
        /** @var \App\Entity\AuthUser $user */
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->add("send", SubmitType::class, ['label' => "Valider les changements"]);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form -> isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', "Modifications réussies");
        }
        
        $args = array("editForm" => $form->createView());
        return $this->render('profile/index.html.twig', $args);
    }
}
