<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ArticleType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    public function formListProductAction(ManagerRegistry $doc, Request $req){
        $em = $doc->getManager();
        $articlesRepo = $em->getRepository("App:Product");
        $articles= $articlesRepo->findAll();

        $form = $this->createForm(ArticleType::class, $articles);

        foreach($articles as $article){
            $form->add(ChoiceType::class, [
                'choices' => $this->arrayOfStock($article)
            ]);
        }

    }

    private function arrayOfStock($article) :array{
        return range(0, $article->getStock());
    }
}
