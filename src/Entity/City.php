<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: '`city`')]
#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, unique: true)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $label;

    #[ORM\Column(type: Types::STRING, length: 5)]
    private string $postalCode;

    #[ORM\Column(type: Types::STRING, length: 5)]
    private string $cityCode;

    public function __toString(): string
    {
        return $this->postalCode . ' ' . $this->label;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCityCode(): ?string
    {
        return $this->cityCode;
    }

    public function setCityCode(string $cityCode): static
    {
        $this->cityCode = $cityCode;

        return $this;
    }
}
