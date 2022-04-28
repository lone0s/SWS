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

#[Route('/product', name: 'product')]
class ProductController extends AbstractController
{
    #[Route('/get_list', name: '_get_list')]
    public function listProductsAction(ManagerRegistry $doc): Response
    {
        $em = $doc -> getManager();
        $artRep = $em -> getRepository("App:Product");
        $articles = $artRep -> findAll();
        dump($articles);
        $args = array('articles' => $articles);
        return $this -> render("site/liste.html.twig", $args);
    }

    #[Route('/add', name: '_add')]
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
            return $this -> redirectToRoute("product_get_list");
        }
        if($form -> isSubmitted()) {
            $this->addFlash('info', "Ajout non réussi: veuillez vérifier les champs saisies");
        }

        $args = array("formulaire" => $form->createView());
        return $this -> render("Form/articleForm.html.twig",$args);
    }
    //Penser a gérer les Requirements
    #[Route('/add_to_basket/{id}/{quantity}', name : '_add_to_basket', defaults: ['quantity' => 1])]
    public function addToBasket(ManagerRegistry $doc, $id, $quantity=1) : Response
    {
        $em = $doc -> getManager();
        $productRepository = $em -> getRepository("App:Product");
        //TRAITER CAS OU QUELQU'UN RENTRE LA ROUTE MANUELLEMENT
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
                    $basketProduct->setQuantity($quantity);
                    $userBasket->addBasketProduct($basketProduct);
                    dump($product);
                }
                else {
                    $basketProduct = $userBasket ->getBasketProduct($product);
                    $basketProduct ->setQuantity($basketProduct -> getQuantity() + $quantity);
                    dump($product);
                }
                //Traiter cas ou on force quantity <<< stock
                $product->setStock($product->getStock() - $quantity);
                $em->persist($basketProduct);
                $em->persist($userBasket);
                $em->persist($product);
                $em->flush();
                $this->addFlash('success', "Ajout dans panier reussi");
            }
        }
        return $this -> redirectToRoute('product_get_list');
    }

    #[Route('/remove/{id}', name : '_remove')]
    public function removeFromBasket(ManagerRegistry $doc, $id) : Response {
        $em = $doc -> getManager();
        $bProductRepository = $em -> getRepository('App:BasketProduct');
        /** @var User $user */
        $user = $this -> getUser();
        $userBasket = $user -> getBasket();
        if (!is_null($userBasket) && !is_null($userBasket->getBasketProducts())) {
            $basketProduct = $bProductRepository -> find($id);
            if(!is_null($basketProduct)) {
                $quantity = $basketProduct->getQuantity();
                $product = $basketProduct->getProduct();
                if(!is_null($product)) {
                    $product->setStock($product->getStock() + $quantity);
                    $userBasket->removeBasketProduct($basketProduct);
                    $em->persist($product);
                    $em->persist($userBasket);
                    $em->flush();
                }
            }
        }
        return $this -> redirectToRoute('product_basket');
    }

    #[Route('/empty', name:'_vider_panier')]
    public function emptyBasket(ManagerRegistry $doc) : Response {
        $em = $doc -> getManager();
        /** @var User $user */
        $user = $this -> getUser();
        if(!is_null($user)){
            $userBasket = $user -> getBasket();
            if(!is_null($userBasket)){
                $userBasketProducts = $userBasket -> getBasketProducts();
                if(!$userBasketProducts ->isEmpty()){
                    foreach ($userBasketProducts as $userBasketProduct){
                        $productId = $userBasketProduct -> getId();
                        $productQuantity = $userBasketProduct -> getQuantity();
                        $bProductRepo = $em -> getRepository("App:BasketProduct");
                        $dbbBProduct = $bProductRepo -> find($userBasketProduct);
                        $productRepo = $em -> getRepository("App:Product");
                        $dbbProduct = $productRepo -> find($dbbBProduct->getProduct()->getId());
                        dump($dbbBProduct);
                        dump($dbbProduct);
                        if(!is_null($dbbBProduct)) {
                            $dbbProduct->setStock($dbbProduct->getStock() + $productQuantity);
                            dump($dbbBProduct);
                                $userBasket->removeBasketProduct($dbbBProduct);
                                $em ->persist($userBasket);
                                $em -> persist($dbbBProduct);
                                $em -> flush();
                        }
                    }
                }
            }
        }
        return $this -> redirectToRoute('product_basket');
    }

    #[Route('/commander', name: '_commander')]
    public function commander(ManagerRegistry $doc) : Response {
        $em = $doc -> getManager();
        /** @var User $user */
        $user = $this -> getUser();
        $userBasket = $user -> getBasket();
        if(!is_null($userBasket)){
            $userBasketProducts = $userBasket -> getBasketProducts();
            foreach ($userBasketProducts as $product){
                $userBasket ->removeBasketProduct($product);
            }
            $em -> persist($userBasket);
            $em -> flush();
        }
        return $this -> redirectToRoute('product_basket');
    }

    #[Route('/debug', name: '_debug')]
    public function getUserVarDump(ManagerRegistry $doc) : Response {
        $em = $doc -> getManager();
        $productRepository = $em -> getRepository("App:Product");
        $product = $productRepository -> find(3);
        /** @var User $user */
        $user = $this -> getUser();
        $userBasket = $user -> getBasket();
        //dump($userTest);
        return dump($userBasket);
    }

    #[Route('/basket', name: '_basket')]
    public function listBasketProductsAction(ManagerRegistry $doc): Response
    {
        $em = $doc -> getManager();
        $artRep = $em -> getRepository("App:Product");
        $user = $this -> getUser();
        /** @var User $user */
        if(!is_null($user)) {
            $userBasket = $user->getBasket();
            if(!is_null($userBasket)) {
                $userBasketContent = $userBasket->getBasketProducts();
                if (!$userBasketContent->isEmpty()) {
                    /**
                     * Permet d'attribuer a chaque article son libelle correspondant
                     * étant donné que la collection ne conserve pas les informations
                     * des produits qu'elle contient
                     */
                    foreach ($userBasketContent as $product) {
                        $localProduct = $product->getProduct();
                        if (!is_null($localProduct)) {
                            $localProductID = $localProduct -> getId();
                            $realProduct = $artRep->find($localProductID);
                            if(!is_null($realProduct)) {
                                $prix = $realProduct->getPrice();
                                $libelle = $realProduct->getLibelle();
                                $product->getProduct()->setLibelle($libelle);
                                $product->getProduct()->setPrice($prix);
                            }
                        }
                    }
                }
            }
            $res = $userBasket->getBasketProductsArray();
            $args = array('articles' => $res);
        }
        return $this -> render("site/basket.html.twig", $args);
    }
}
