<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass=WeatherRepository::class)
 * @JMS\ExclusionPolicy("all")
 * @author Karol Gancarczyk
 */
class Weather
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $city;

    /**
     * @ORM\Column(type="float")
     */
    private float $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private float $longitude;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose()
     */
    private float $temperature;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose()
     */
    private float $wind;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose()
     */
    private float $clouds;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Expose()
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $searchDateTime;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getWind(): float
    {
        return $this->wind;
    }

    public function setWind(float $wind): self
    {
        $this->wind = $wind;

        return $this;
    }

    public function getClouds(): float
    {
        return $this->clouds;
    }

    public function setClouds(float $clouds): self
    {
        $this->clouds = $clouds;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSearchDateTime(): \DateTimeInterface
    {
        return $this->searchDateTime;
    }

    public function setSearchDateTime(\DateTimeInterface $searchDateTime): self
    {
        $this->searchDateTime = $searchDateTime;

        return $this;
    }
}
