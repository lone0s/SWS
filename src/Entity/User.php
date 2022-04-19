<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * User
 *
 * @ORM\Table(name="im22_user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname_lastname", type="string", length=50, nullable=false)
     */
    private $firstnameLastname;

    /**
     * @var Date
     *
     * @ORM\Column(name="birthdate", type="date", nullable=false)
     */
    private $birthdate;

    /**
     * @var bool
     *
     * @ORM\Column(name="isAdmin", type="boolean", nullable=false)
     */
    private $isadmin;

    /**
     * @var bool
     *
     * @ORM\Column(name="isSuperAdmin", type="boolean", nullable=false)
     */
    private $issuperadmin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_article", type="integer", nullable=true)
     */
    private $idArticle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstnameLastname(): ?string
    {
        return $this->firstnameLastname;
    }

    public function setFirstnameLastname(string $firstnameLastname): self
    {
        $this->firstnameLastname = $firstnameLastname;

        return $this;
    }

    public function getIsadmin(): ?bool
    {
        return $this->isadmin;
    }

    public function setIsadmin(bool $isadmin): self
    {
        $this->isadmin = $isadmin;

        return $this;
    }

    public function getIssuperadmin(): ?bool
    {
        return $this->issuperadmin;
    }

    public function setIssuperadmin(bool $issuperadmin): self
    {
        $this->issuperadmin = $issuperadmin;

        return $this;
    }

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function setIdArticle(?int $idArticle): self
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }


}
