<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryNameFr;

 
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagePays;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function getCountryNameFr(): ?string
    {
        return $this->countryNameFr;
    }

    public function setCountryNameFr(string $countryNameFr): self
    {
        $this->countryNameFr = $countryNameFr;

        return $this;
    }


    public function getImagePays(): ?string
    {
        return $this->imagePays;
    }

    public function setImagePays(?string $imagePays): self
    {
        $this->imagePays = $imagePays;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
