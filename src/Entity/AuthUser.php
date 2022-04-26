<?php

namespace App\Entity;

use App\Repository\AuthUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AuthUserRepository::class)]
#[UniqueEntity(fields: ['login'], message: 'There is already an account with this login')]
class AuthUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(){
        $panier = new Panier($this);
        $this->setPanier($panier);
        $this->setRoles((array)"ROLE_USER");
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $login;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string', nullable: false)]
    private $password;

    #[ORM\Column(type: 'string', nullable : false)]
    private $firstName;

    #[ORM\Column(type: 'string', nullable : false)]
    private $lastName;

    #[ORM\OneToOne(targetEntity: Panier::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $panier;
    /*
    #[ORM\OneToOne(mappedBy: 'id', targetEntity: Panier::class, cascade: ['persist', 'remove'])]
    private $id_panier;*/

    /*public function getIdUser(): ?int
    {
        return $this->id_user;
    }*/

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /*public function getIdPanier(): ?Panier
    {
        return $this->id_panier;
    }

    public function setIdPanier(Panier $id_panier): self
    {
        // set the owning side of the relation if necessary
        if ($id_panier->getIdUser() !== $this) {
            $id_panier->setIdUser($this);
        }

        $this->id_panier = $id_panier;

        return $this;
    }*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(Panier $panier): self
    {
        $this->panier = $panier;

        return $this;
    }
}
