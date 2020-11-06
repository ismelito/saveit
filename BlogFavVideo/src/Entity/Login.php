<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Repository\LoginRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoginRepository::class)
 */
class Login
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255 )
     * @Assert\Email(message = "Le mail'{{ value }}' n'est pas un mail valide. .")
     * @Assert\NotBlank(message = "Le mail ne peut pas être vide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Le mot de passe ne peut pas être vide")
     */
    private $password;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
