<?php

namespace App\Entity;

use App\Repository\ForecastMoneyExpenseInstanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForecastMoneyExpenseInstanceRepository::class)
 */
class ForecastMoneyExpenseInstance
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
     * @ORM\ManyToOne(targetEntity=ForecastMoneyExpense::class, inversedBy="forecastMoneyExpenseInstances")
     */
    private $forecastMoneyExpense;

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

    public function getForecastMoneyExpense(): ?ForecastMoneyExpense
    {
        return $this->forecastMoneyExpense;
    }

    public function setForecastMoneyExpense(?ForecastMoneyExpense $forecastMoneyExpense): self
    {
        $this->forecastMoneyExpense = $forecastMoneyExpense;

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
