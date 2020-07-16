<?php

namespace App\Entity;

use App\Repository\ForecastMoneyExpenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForecastMoneyExpenseRepository::class)
 */
class ForecastMoneyExpense
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
    private $forecastMoneyExpenseInstances;

    public function __construct()
    {
        $this->forecastMoneyExpenseInstances = new ArrayCollection();
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
    public function getForecastMoneyExpenseInstances(): Collection
    {
        return $this->forecastMoneyExpenseInstances;
    }

    public function addForecastMoneyExpenseInstance(ForecastMoneyExpenseInstance $forecastMoneyExpenseInstance): self
    {
        if (!$this->forecastMoneyExpenseInstances->contains($forecastMoneyExpenseInstance)) {
            $this->forecastMoneyExpenseInstances[] = $forecastMoneyExpenseInstance;
            $forecastMoneyExpenseInstance->setForecastMoneyExpense($this);
        }

        return $this;
    }

    public function removeForecastMoneyExpenseInstance(ForecastMoneyExpenseInstance $forecastMoneyExpenseInstance): self
    {
        if ($this->forecastMoneyExpenseInstances->contains($forecastMoneyExpenseInstance)) {
            $this->forecastMoneyExpenseInstances->removeElement($forecastMoneyExpenseInstance);
            // set the owning side to null (unless already changed)
            if ($forecastMoneyExpenseInstance->getForecastMoneyExpense() === $this) {
                $forecastMoneyExpenseInstance->setForecastMoneyExpense(null);
            }
        }

        return $this;
    }
}
