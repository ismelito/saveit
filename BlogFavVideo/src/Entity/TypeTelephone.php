<?php

namespace App\Entity;

use App\Repository\TypeTelephoneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeTelephoneRepository::class)
 */
class TypeTelephone
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
    private $typetelephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypetelephone(): ?string
    {
        return $this->typetelephone;
    }

    public function setTypetelephone(string $typetelephone): self
    {
        $this->typetelephone = $typetelephone;

        return $this;
    }
}
