<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $salarier = null;

    #[ORM\Column(length: 255)]
    private ?string $entrepreneur = null;

    #[ORM\Column(length: 255)]
    private ?string $etufiant = null;

    #[ORM\Column(length: 255)]
    private ?string $autre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSalarier(): ?string
    {
        return $this->salarier;
    }

    public function setSalarier(string $salarier): static
    {
        $this->salarier = $salarier;

        return $this;
    }

    public function getEntrepreneur(): ?string
    {
        return $this->entrepreneur;
    }

    public function setEntrepreneur(string $entrepreneur): static
    {
        $this->entrepreneur = $entrepreneur;

        return $this;
    }

    public function getEtufiant(): ?string
    {
        return $this->etufiant;
    }

    public function setEtufiant(string $etufiant): static
    {
        $this->etufiant = $etufiant;

        return $this;
    }

    public function getAutre(): ?string
    {
        return $this->autre;
    }

    public function setAutre(string $autre): static
    {
        $this->autre = $autre;

        return $this;
    }
}
