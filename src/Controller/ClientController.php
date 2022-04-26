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
        $user = $this -> getUser();
        dump($user);
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

    // NE SURTOUT PAS UTILISER NE FONCTIONNE PAS
    // SAUF SI TU VEUX ENCORE PLUS TOUT NIQUER
    // DIEU FACE A MA VIE ETRE COMME UTILISER CETTE FONCTION 10X PAR JOUR
    #[Route('/product/add/{id}', name : '_add_product_to_basket')]

    public function addToBasket(ManagerRegistry $doc, $id) : Response
    {
        //On recup l'article correspondant
        $em = $doc -> getManager();
        $articleRep = $em -> getRepository("App:Article");
        //On recup repo Panier
        $article = $articleRep -> find($id);
        $panierRep = $em -> getRepository("App:Panier");
        //On
        /** @var \App\Entity\AuthUser $user */
        $user = $this -> getUser();
        $userId = $user -> getIdUser();
        // Il faut que clé primaire Panier = clé primaire auth_user + articles ==> table de jointure mais comment frere???
        $panier = $panierRep -> find($userId);
        $panier -> addIdArticle($article);
        $panier -> setQuantite(1);
        // BREF REVOIR CONCEPTION TABLE PANIER PCQ Y A RIEN QUI VA ZEBI ET CA M'FRACASSE LE CUL PAR ALLAH
    }

}
