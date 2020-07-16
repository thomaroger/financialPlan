<?php

namespace App\Entity;

use App\Repository\ForecastMoneyEntryInstanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForecastMoneyEntryInstanceRepository::class)
 */
class ForecastMoneyEntryInstance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=ForecastMoneyEntry::class, inversedBy="forecastMoneyEntryInstances")
     */
    private $ForecastMoneyEntry;

    /**
     * @ORM\Column(type="integer")
     */
    private $month;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getForecastMoneyEntry(): ?ForecastMoneyEntry
    {
        return $this->ForecastMoneyEntry;
    }

    public function setForecastMoneyEntry(?ForecastMoneyEntry $ForecastMoneyEntry): self
    {
        $this->ForecastMoneyEntry = $ForecastMoneyEntry;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }
}
