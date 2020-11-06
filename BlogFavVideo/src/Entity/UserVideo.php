<?php

namespace App\Entity;

use App\Repository\UserVideoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserVideoRepository::class)
 */
class UserVideo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */

    private $idUser;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=Video::class)
     * @ORM\JoinColumn(name="video_id", referencedColumnName="id")
     */

    private $idVideo;

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

    public function getIdVideo(): ?int
    {
        return $this->idVideo;
    }

    public function setIdVideo(int $idVideo): self
    {
        $this->idVideo = $idVideo;

        return $this;
    }
}
