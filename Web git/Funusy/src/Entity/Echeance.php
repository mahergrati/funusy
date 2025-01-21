<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EcheanceRepository;

#[ORM\Entity(repositoryClass: EcheanceRepository::class)]

class Echeance
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "numero", type: "integer", nullable: false)]
    private ?int $numero;

    #[ORM\Column(name: "echeance", type: "date", nullable: true)]
    private ?\DateTimeInterface $echeance;

    #[ORM\Column(name: "principal", type: "float", precision: 10, scale: 0, nullable: true)]
    private ?float $principal;

    #[ORM\Column(name: "valeurResiduelle", type: "float", precision: 10, scale: 0, nullable: true)]
    private ?float $valeurresiduelle;

    #[ORM\Column(name: "interets", type: "float", precision: 10, scale: 0, nullable: true)]
    private ?float $interets;

    #[ORM\Column(name: "mensualite", type: "float", precision: 10, scale: 0, nullable: true)]
    private ?float $mensualite;

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function getEcheance(): ?\DateTimeInterface
    {
        return $this->echeance;
    }

    public function setEcheance(?\DateTimeInterface $echeance): static
    {
        $this->echeance = $echeance;
        return $this;
    }

    public function getPrincipal(): ?float
    {
        return $this->principal;
    }

    public function setPrincipal(?float $principal): static
    {
        $this->principal = $principal;
        return $this;
    }

    public function getValeurresiduelle(): ?float
    {
        return $this->valeurresiduelle;
    }

    public function setValeurresiduelle(?float $valeurresiduelle): static
    {
        $this->valeurresiduelle = $valeurresiduelle;
        return $this;
    }

    public function getInterets(): ?float
    {
        return $this->interets;
    }

    public function setInterets(?float $interets): static
    {
        $this->interets = $interets;
        return $this;
    }

    public function getMensualite(): ?float
    {
        return $this->mensualite;
    }

    public function setMensualite(?float $mensualite): static
    {
        $this->mensualite = $mensualite;
        return $this;
    }
}
