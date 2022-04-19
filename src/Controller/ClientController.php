<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/product', name: '_get_products')]
    public function listProductsAction(ManagerRegistry $doc): Response
    {
        $em = $doc -> getManager();
        $artRep = $em -> getRepository("App:Article");
        $articles = $artRep -> findAll();
        $args = array('articles' => $articles);
        return $this -> render("site/liste.html.twig", $args);
    }

    #[Route('/add_product', name: '_add_product')]

    public function addProductAction(ManagerRegistry $doc, Request $request) : Response
    {
        $em = $doc -> getManager();
        $article = new Article();
        $form = $this -> createForm(ArticleType::class,$article);
        $form -> add("send", SubmitType::class, ['label' => "Ajouter un article"]);
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid()) {
            $article = $form -> getData();
            $em -> persist($article);
            $em -> flush();
            $this -> addFlash('info', "Ajout d'un article réussi");
            return $this -> redirectToRoute("_get_products");
        }
        if($form -> isSubmitted()) {
            $this->addFlash('info', "Ajout non réussi: veuillez vérifier les champs saisies");
        }

        $args = array("formulaire" => $form->createView());
        return $this -> render("Form/articleForm.html.twig",$args);
    }

}
