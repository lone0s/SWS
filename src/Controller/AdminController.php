<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin')]
class AdminController extends AbstractController
{
    #[Route('/user_management', name: '_user_management')]
    public function userManagementAction(ManagerRegistry $doc): Response
    {
        $em = $doc->getManager();
        $userRepo = $em->getRepository("App:User");
        $users = $userRepo->findAll();
        dump($users);
        $args = array('users' => $users);
        return $this->render('admin/delete_user.html.twig', $args);
    }

    #[Route('/user_role', name: '_user_role')]
    public function userRoleAction(ManagerRegistry $doc): Response
    {
        $em = $doc->getManager();
        $userRepo = $em->getRepository("App:User");
        $users = $userRepo->findAll();
        $args = array('users' => $users);
        return $this->render('admin/role_user.html.twig', $args);
    }

    #[Route('/delete_user/{id}', name: '_delete_user')]
    public function deleteUserAction(ManagerRegistry $doc, $id): Response
    {
        $em = $doc->getManager();
        $userRepo = $em->getRepository("App:User");
        $panierRepo = $em->getRepository("App:Basket");
        $articleRepo = $em -> getRepository("App:Product");
        $user = $userRepo->find($id);
        $panier = $panierRepo->find($user->getBasket());
        $panierArticles = $panier -> getBasketProducts();
        if($user != null){
            if(!$panierArticles ->isEmpty()) {
                foreach ($panierArticles as $localArticle) {
                    $localArticle ->setBasket(null);
                    $articleBdd = $articleRepo ->find($localArticle);
                    $articleBdd -> setStock($articleBdd->getStock() + $localArticle->getQuantity());
                    $panier -> removeBasketProduct($localArticle);
                    $em -> persist($articleBdd);
                }
            }
            $em->remove($user);
            $em->remove($panier);
            $em->flush();
            $this->addFlash('info', 'Suppresion réussie !');
        }
        else{
            $this->addFlash('info', 'Utilisateur inconnu !');
        }
        return $this->redirectToRoute('admin_user_management');
    }

    #[Route('/add_admin/{id}', name: '_add_admin')]
    public function addAdminAction(ManagerRegistry $doc, $id): Response
    {
        $em = $doc->getManager();
        $userRepo = $em->getRepository("App:User");
        $user = $userRepo->find($id);
        if($user != null){
            $user->setRoles('ROLE_ADMIN');
            $em->flush();
            $this->addFlash('info', 'Ajoute admin réussi !');
        }
        else{
            $this->addFlash('info', 'Utilisateur inconnu !');
        }
        return $this->redirectToRoute('admin_user_management');
    }
}
