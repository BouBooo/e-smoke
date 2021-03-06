<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields = { "email" },
 *     message = "L'email renseigné est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vos mots de passe ne correspondent pas")
     */
    private $confirmPassword;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Liquid", inversedBy="users")
     */
    private $panier;

    public function __construct()
    {
        $this->panier = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function eraseCredentials() {

    }

    public function getSalt() {

    }

    public function getRoles() {
        return ['ROLE_USER'];
    }

    /**
     * @return Collection|Liquid[]
     */
    public function getPanier(): Collection
    {
        return $this->panier;
    }

    public function addPanier(Liquid $panier, int $capacity, int $dosage): self
    {
        if (!$this->panier->contains($panier)) {
            $this->panier[] = $panier;
        }
        $panier->setCapacity($capacity);
        $panier->setDosage($dosage);
        return $this;
    }

    public function removePanier(Liquid $panier): self
    {
        if ($this->panier->contains($panier)) {
            $this->panier->removeElement($panier);
        }

        return $this;
    }
}
