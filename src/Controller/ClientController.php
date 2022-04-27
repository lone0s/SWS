<?php

namespace App\Controller;

use App\Entity\BasketProduct;
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
        $productRepository = $em -> getRepository("App:Product");
        $product = $productRepository -> find($id);
        dump($product);
        if (!is_null($product) && $product -> getStock() > 0 )
        {
            /** @var User $user */
            $user = $this -> getUser();
            dump($user);
            if(!is_null($user)) {
                $userBasket = $user -> getBasket();
                dump($userBasket);
                /*** Si article pas deja present dans panier ***/
                if (!$userBasket -> hasProduct($product)) {
                    $basketProduct = new BasketProduct();
                    $basketProduct->setBasket($userBasket);
                    $basketProduct->setProduct($product);
                    $basketProduct->setQuantity(1);
                    $userBasket->addBasketProduct($basketProduct);
                    dump($product);
                }
                else {
                    $basketProduct = $userBasket ->getBasketProduct($product);
                    $basketProduct ->setQuantity($basketProduct -> getQuantity() + 1);
                    dump($product);
                }
                $product->setStock($product->getStock() - 1);
                $em->persist($basketProduct);
                $em->persist($userBasket);
                $em->persist($product);
                $em->flush();
                $this->addFlash('success', "Ajout dans panier reussi");
            }
        }
        return $this -> redirectToRoute('_get_products');
    }

    #[Route('/userInfo', name: '_userInfo')]
    public function getUserVarDump(ManagerRegistry $doc) : Response {
        $em = $doc -> getManager();
        $productRepository = $em -> getRepository("App:Product");
        $product = $productRepository -> find(3);
        /** @var User $user */
        $user = $this -> getUser();
        $userBasket = $user -> getBasket();
        dump($userBasket -> hasProduct($product));
        //dump($userTest);
        return dump($userBasket);
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
