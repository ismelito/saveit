<?php

namespace App\Entity;

use App\Repository\TelephoneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TelephoneRepository::class)
 */
class Telephone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *  @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $idUser;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity=TypeTelephone::class)
     * @ORM\JoinColumn(name="typeTelephone_id", referencedColumnName="id")
     */
    private $idTypeTelephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdTypeTelephone(): ?int
    {
        return $this->idTypeTelephone;
    }

    public function setIdTypeTelephone(int $idTypeTelephone): self
    {
        $this->idTypeTelephone = $idTypeTelephone;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
