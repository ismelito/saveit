<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )

     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
