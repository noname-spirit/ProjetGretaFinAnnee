<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $nonAbonne = null;

    #[ORM\Column]
    private ?bool $abonne = null;

    #[ORM\Column]
    private ?bool $dev = null;

    #[ORM\Column]
    private ?bool $stagiaire = null;

    #[ORM\Column]
    private ?bool $superAdmin = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'idRole')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function isNonAbonne(): ?bool
    {
        return $this->nonAbonne;
    }

    public function setNonAbonne(bool $nonAbonne): static
    {
        $this->nonAbonne = $nonAbonne;

        return $this;
    }

    public function isAbonne(): ?bool
    {
        return $this->abonne;
    }

    public function setAbonne(bool $abonne): static
    {
        $this->abonne = $abonne;

        return $this;
    }

    public function isDev(): ?bool
    {
        return $this->dev;
    }

    public function setDev(bool $dev): static
    {
        $this->dev = $dev;

        return $this;
    }

    public function isStagiaire(): ?bool
    {
        return $this->stagiaire;
    }

    public function setStagiaire(bool $stagiaire): static
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    public function isSuperAdmin(): ?bool
    {
        return $this->superAdmin;
    }

    public function setSuperAdmin(bool $superAdmin): static
    {
        $this->superAdmin = $superAdmin;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setIdRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getIdRole() === $this) {
                $user->setIdRole(null);
            }
        }

        return $this;
    }
}
