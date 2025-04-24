<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, unique: true)] // Ajout de l'unicité pour l'email
    private ?string $email = null;

    #[ORM\Column(length: 8)]
    private ?string $mp = null; // Considérez renommer en 'motDePasse' pour plus de clarté

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Role $idRole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getMp(): ?string // Considérez renommer en 'getMotDePasse'
    {
        return $this->mp;
    }

    public function setMp(string $mp): static // Considérez renommer en 'setMotDePasse'
    {
        $this->mp = $mp;
        return $this;
    }

    public function getIdRole(): ?Role
    {
        return $this->idRole;
    }

    public function setIdRole(?Role $idRole): static
    {
        $this->idRole = $idRole;
        return $this;
    }
}
