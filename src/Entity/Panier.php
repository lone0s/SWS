<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=AuthUser::class)
     * @ORM\JoinColum(name="id_user", nullable=false)
     */
    private $id_user;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity=Article::class)
     * @ORM\JoinColum(name="id_panier", nullable=false)
     */
    private $id_article;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdArticle(): ?int
    {
        return $this->id_article;
    }

    public function setIdArticle(?int $id_article): self
    {
        $this->id_article = $id_article;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
