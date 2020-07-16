<?php

namespace App\Entity;

use App\Repository\ForecastMoneyEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForecastMoneyEntryRepository::class)
 */
class ForecastMoneyEntry
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="forecastMoneyEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $recurrent;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=ForecastMoneyEntryInstance::class, mappedBy="ForecastMoneyEntry")
     */
    private $forecastMoneyEntryInstances;

    public function __construct()
    {
        $this->forecastMoneyEntryInstances = new ArrayCollection();
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRecurrent(): ?bool
    {
        return $this->recurrent;
    }

    public function setRecurrent(bool $recurrent): self
    {
        $this->recurrent = $recurrent;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|ForecastMoneyEntryInstance[]
     */
    public function getForecastMoneyEntryInstances(): Collection
    {
        return $this->forecastMoneyEntryInstances;
    }

    public function addForecastMoneyEntryInstance(ForecastMoneyEntryInstance $forecastMoneyEntryInstance): self
    {
        if (!$this->forecastMoneyEntryInstances->contains($forecastMoneyEntryInstance)) {
            $this->forecastMoneyEntryInstances[] = $forecastMoneyEntryInstance;
            $forecastMoneyEntryInstance->setForecastMoneyEntry($this);
        }

        return $this;
    }

    public function removeForecastMoneyEntryInstance(ForecastMoneyEntryInstance $forecastMoneyEntryInstance): self
    {
        if ($this->forecastMoneyEntryInstances->contains($forecastMoneyEntryInstance)) {
            $this->forecastMoneyEntryInstances->removeElement($forecastMoneyEntryInstance);
            // set the owning side to null (unless already changed)
            if ($forecastMoneyEntryInstance->getForecastMoneyEntry() === $this) {
                $forecastMoneyEntryInstance->setForecastMoneyEntry(null);
            }
        }

        return $this;
    }
}
