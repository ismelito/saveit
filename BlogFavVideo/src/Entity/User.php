<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity=Login::class)
     * @ORM\JoinColumn(name="login_id", referencedColumnName="id")
     */
    private $idLogin;

    /**
     * @ORM\Column(type="boolean", options={"default":"1"})
     */
    protected $isActive = true;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=Sex::class)
     * @ORM\JoinColumn(name="sex_id", referencedColumnName="id")
     */
    private $idSex;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=Nationality::class)
     * @ORM\JoinColumn(name="nationality_id", referencedColumnName="id")
     */

    private $idNationality;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=MaritalStatus::class)
     * @ORM\JoinColumn(name="maritalStatus_id", referencedColumnName="id")
     */

    private $idMaritalStatus;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */

    private $idRole;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getIdLogin(): ?int
    {
        return $this->idLogin;
    }

    public function setIdLogin(int $idLogin): self
    {
        $this->idLogin = $idLogin;

        return $this;
    }

    public function getIdSex(): ?int
    {
        return $this->idSex;
    }

    public function setIdSex(int $idSex): self
    {
        $this->idSex = $idSex;

        return $this;
    }

    public function getIdNationality(): ?int
    {
        return $this->idNationality;
    }

    public function setIdNationality(int $idNationality): self
    {
        $this->idNationality = $idNationality;

        return $this;
    }

    public function getIdMaritalStatus(): ?int
    {
        return $this->idMaritalStatus;
    }

    public function setIdMaritalStatus(int $idMaritalStatus): self
    {
        $this->idMaritalStatus = $idMaritalStatus;

        return $this;
    }


    public function getIdRole(): ?int
    {
        return $this->idRole;
    }

    public function setIdRole(int $idRole): self
    {
        $this->idRole = $idRole;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
