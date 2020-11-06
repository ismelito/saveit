<?php

namespace App\Entity;

use App\Repository\MaritalStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaritalStatusRepository::class)
 */
class MaritalStatus
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
    private $maritalStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(string $maritalStatus): self
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }
}
