<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ArticleType;
use App\Form\ListProductType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', name: 'product')]
class FormController extends AbstractController
{
    #[Route('/get_list', name: 'get_list')]
    public function formListProductAction(ManagerRegistry $doc, Request $req){
        $em = $doc->getManager();
        $articlesRepo = $em->getRepository("App:Product");
        $articles= $articlesRepo->findAll();


        $form = $this->createForm(ListProductType::class, $articles);

        foreach($articles as $article){
            $arr = $this->arrayOfStock($article);
            $form->add('choice', ChoiceType::class, [
                'choices' => array_push($arr)
            ]);
        }

        $form->handleRequest($req);


        if($form->isSubmitted() && $form->isValid()){

        }

        return $this->render('site/liste.html.twig', [
            'listProductForm' => $form->createView(),
        ]);
    }

    private function arrayOfStock($article) :array{
        return range(0, $article->getStock());
    }
}
