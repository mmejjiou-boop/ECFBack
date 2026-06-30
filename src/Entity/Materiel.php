<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $referance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_achat = null;

    #[ORM\Column]
    private ?bool $disponible = null;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getReferance(): ?string
    {
        return $this->referance;
    }

    public function setReferance(string $referance): static
    {
        $this->referance = $referance;

        return $this;
    }

    public function getDateAchat(): ?\DateTime
    {
        return $this->date_achat;
    }

    public function setDateAchat(\DateTime $date_achat): static
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;

        return $this;
    }
}
