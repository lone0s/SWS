<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table (name: 'Panier')]
#[ORM\UniqueConstraint (name : "au_idx", columns: ["user_id","article_id","quantite"])]
#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: AuthUser::class)]
    #[ORM\JoinColumn( nullable: false)]
    private $user;
    
    #[ORM\ManyToOne(targetEntity: Article::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $article;

    #[ORM\Column(type: 'integer', nullable : true)]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
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
}
