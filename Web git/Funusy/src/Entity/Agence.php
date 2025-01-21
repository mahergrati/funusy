<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "code_agence", type: "integer", nullable: false)]
    private int $codeAgence;

    #[ORM\Column(name: "adresse", type: "string", length: 255, nullable: false)]
    private string $adresse;

    #[ORM\Column(name: "codepostal", type: "integer", nullable: false)]
    private int $codepostal;

    public function getCodeAgence(): ?int
    {
        return $this->codeAgence;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }
}