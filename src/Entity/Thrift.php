<?php

namespace App\Entity;

use App\Repository\ThriftRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThriftRepository::class)
 */
class Thrift
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
    private $bank;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="thrifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $balance;

    /**
     * @ORM\Column(type="integer")
     */
    private $ratio;

    /**
     * @ORM\Column(type="boolean")
     */
    private $available;

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

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getRatio(): ?int
    {
        return $this->ratio;
    }

    public function setRatio(int $ratio): self
    {
        $this->ratio = $ratio;

        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }
}
