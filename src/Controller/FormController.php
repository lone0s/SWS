<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ArticleType;
use App\Form\ListProductType;
use App\Services\ServiceInverse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

#[Route('/form', name: 'form')]
class FormController extends AbstractController
{
    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[Route('/service', name: '_service')]
    public function serviceAction(Request $req, ServiceInverse $si) : Response{
        if($req->isMethod('post')){
            $post = $req->request->get("name");
            dump($post);

            $serv = $si->inversePhrase($post);
            $args = ['res' => $serv];
        }
        else{
            $args = null;
        }


        return $this->render('site/service.html.twig', $args);

    }
    //Controleur destiné a lister les produits et un combobox mais impossible avec symfony
    /*#[Route('/get_list', name: '_get_list')]
    public function formListProductAction(ManagerRegistry $doc, Request $req) : Response {
        $em = $doc->getManager();
        $articlesRepo = $em->getRepository("App:Product");
        $articles = $articlesRepo->findAll();
        dump($articles);

        $form = $this->createForm(ListProductType::class, $articles);

        $form->handleRequest($req);


        if($form->isSubmitted() && $form->isValid()){

        }

        return $this->render('site/liste.html.twig', [
            'listProductForm' => $form->createView(),
        ]);
    }

    private function arrayOfStock($article) :array{
        return range(0, $article->getStock());
    }*/
}

