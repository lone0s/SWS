<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfilType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app', name: 'app')]
class ProfileController extends AbstractController
{
    #[Route('/editprofile', name: '_edit_profile')]
    public function editProfileAction(ManagerRegistry $doc, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $em = $doc->getManager();
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->add("send", SubmitType::class, ['label' => "Valider les changements"]);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form -> isValid()) {
            $user = $form->getData();
            if($form->get('password') != null) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', "Modifications réussies");
            if(in_array('ROLE_SUPER_ADMIN', $user->getRoles()))
                return $this->redirectToRoute('app_main');
            else
                return $this->redirectToRoute('product_get_list');
        }
        
        $args = array("editForm" => $form->createView());
        return $this->render('profile/editprofile.html.twig', $args);
    }
}
