<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
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
        $artRep = $em -> getRepository("App:Product");
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
        $article = new Product();
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

    #[Route('/product/add/{id}', name : '_add_product_to_basket')]
    public function addToBasket(ManagerRegistry $doc, $id) : Response
    {
        $em = $doc -> getManager();
        $articleRep = $em -> getRepository("App:Article");
        $article = $articleRep -> find($id);
        dump($article);
        $panierRep = $em -> getRepository("App:Panier");
        /** @var User $user */
        $user = $this -> getUser();
        dump($user);
        $userBasket = $user -> getPanier();
        $bb = $userBasket -> get(0);
        dump($bb);
        $baskets = $userBasket -> getValues();
        dump($baskets);
        $basketId = $bb -> getId();
        dump($basketId);
        $panier = $panierRep -> find($basketId);
        if (!is_null($panier)) {
            //$userBasket -> add($article);
            $panier->setArticle($article);
            $panier->setQuantite(1);
            $this -> addFlash('info','Ajout Reussi');
            $em -> persist($panier);
            $em -> flush();
        }
        return $this -> redirectToRoute('_get_products');
    }

    #[Route('/userInfo', name: '_userInfo')]
    public function getUserVarDump() : Response {
        return dump($this -> getUser());
    }


    //J'ai un don pour les fonctions qui en théorie fonctionnent mais pas en pratique
    #[Route('/basket', name : '_basket')]
    public function showBasket(ManagerRegistry $doc) : Response
    {
        $user = $this -> getUser();
        $articleArray = array();
        if(! is_null($user)) {
            /** @var User $user */
            $userBasket = $user -> getPanier();
            $em = $doc -> getManager();
            $basketRepo = $em -> getRepository("App:Basket");
            $basket = $basketRepo -> find($userBasket);
            if(! is_null($basket)) {
                $articles = $basket->getArticle();
                foreach ($articles as $article) {
                    $articleRepo = $em -> getRepository("App:Product");
                    $articlefin = $articleRepo-> find($article);
                    array_push($articleArray,$articlefin);
                }
            }
        }
        $args = array("articles" => $articleArray);
        return $this -> render("site/liste.html.twig", $args);
    }
}
