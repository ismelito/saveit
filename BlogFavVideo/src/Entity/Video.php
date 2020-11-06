<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=Url::class)
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     */
    private $idUrl;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=VideoStatus::class)
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */

    private $idVideoStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getIdUrl(): ?int
    {
        return $this->idUrl;
    }

    public function setIdUrl(int $idUrl): self
    {
        $this->idUrl = $idUrl;

        return $this;
    }

    public function getIdVideoStatus(): ?int
    {
        return $this->idVideoStatus;
    }

    public function setIdVideoStatus(int $idVideoStatus): self
    {
        $this->idVideoStatus = $idVideoStatus;

        return $this;
    }
}
