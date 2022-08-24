<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateHeureDebut = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateLimiteInscription = null;

    #[ORM\Column]
    private ?int $nbInscriptionsMax = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infosSortie = null;

    #[ORM\Column(length: 30)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeImmutable
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeImmutable $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeImmutable
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeImmutable $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?User $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }
}
