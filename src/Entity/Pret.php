<?php

namespace App\Entity;

use App\Repository\PretRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_pret = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_retour_prevue = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_retour_effective = null;

    #[ORM\ManyToOne(targetEntity: Materiel::class)]
    #[ORM\JoinColumn(name: 'materiel_id', referencedColumnName: 'id', nullable: false)]
    private ?Materiel $materiel = null;

    #[ORM\ManyToOne(targetEntity: Adherent::class)]
    #[ORM\JoinColumn(name: 'adherent_id', referencedColumnName: 'id', nullable: false)]
    private ?Adherent $adherent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDatePret(): ?\DateTime
    {
        return $this->date_pret;
    }

    public function setDatePret(\DateTime $date_pret): static
    {
        $this->date_pret = $date_pret;

        return $this;
    }

    public function getDateRetourPrevue(): ?\DateTime
    {
        return $this->date_retour_prevue;
    }

    public function setDateRetourPrevue(\DateTime $date_retour_prevue): static
    {
        $this->date_retour_prevue = $date_retour_prevue;

        return $this;
    }

    public function getDateRetourEffective(): ?\DateTime
    {
        return $this->date_retour_effective;
    }

    public function setDateRetourEffective(\DateTime $date_retour_effective): static
    {
        $this->date_retour_effective = $date_retour_effective;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): static
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): static
    {
        $this->adherent = $adherent;

        return $this;
    }
}