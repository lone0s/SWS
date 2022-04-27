<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Table (name: 'Panier')]
#[ORM\UniqueConstraint (name : "au_idx", columns: ["id_user","id_article","quantite"])]
#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    public function __construct($user){
        $this->setUser($user);
        $this -> setQuantite(0);
        $this -> setArticle(null);
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: "panier", targetEntity: AuthUser::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id", nullable: false)]
    private $user;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'panier')]
    #[ORM\JoinColumn(name: "id_article", referencedColumnName: "id",nullable: true)]
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUser(): ?AuthUser
    {
        return $this->user;
    }

    public function setUser(?AuthUser $user): self
    {
        $this->user = $user;

        return $this;
    }
/*
    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
*/
    /*#[ORM\ManyToOne(targetEntity: Article::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $article;
    */

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
