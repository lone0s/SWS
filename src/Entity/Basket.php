<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
#[ORM\Table(name: 'im22_Basket')]
class Basket
{
    public function __construct($user){
        $this->setUser($user);
        $this->basketProducts = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'basket', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: BasketProduct::class, orphanRemoval: true)]
    private $basketProducts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, BasketProduct>
     */
    public function getBasketProducts(): Collection
    {
        return $this->basketProducts;
    }

    public function addBasketProduct(BasketProduct $basketProduct): self
    {
        if (!$this->basketProducts->contains($basketProduct)) {
            $this->basketProducts[] = $basketProduct;
            $basketProduct->setBasket($this);
        }

        return $this;
    }

    public function removeBasketProduct(BasketProduct $basketProduct): self
    {
        if ($this->basketProducts->removeElement($basketProduct)) {
            // set the owning side to null (unless already changed)
            if ($basketProduct->getBasket() === $this) {
                $basketProduct->setBasket(null);
            }
        }

        return $this;
    }
    /*** Fait main ***/


    /**
     * @param Product $product
     * @return bool
     * Permet de vérifier l'existence d'un produit recherché dans une collection
     */
  public function hasProduct(Product $product) : bool
    {
        $res = false;
        if(!is_null($this -> basketProducts)) {
            foreach (($this->basketProducts->getValues()) as $value) {
                if ($value -> getProduct() -> getId() == $product -> getId())
                    $res = true;
            }
        }
        return $res;
    }

    /**
     * @param Product $product
     * @return BasketProduct
     * Permet de récuperer le BasketProduct correspondant au Produit recherché
     */
    public function getBasketProduct (Product $product) : BasketProduct
    {
        $res = null;
        if ($this -> hasProduct($product)) {
            foreach (($this -> basketProducts -> getValues()) as $value) {
                if($value -> getProduct() -> getId() == $product -> getId()) {
                     $res = $value;
                }
            }
            return $res;
        }
        else
            return $res;
    }

    /**
     * @return array
     * Permet d'obtenir un tableau
     */
    public function getBasketProductsArray() : array {
        return $this -> basketProducts ->toArray();
    }
}
