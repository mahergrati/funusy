<?php

namespace App\Entity;

use App\Repository\GarantieRepository;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GarantieRepository::class)]
class Garantie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_garantie", type: "integer", nullable: false)]
    private ?int $idGarantie;

    #[ORM\Column(name: "id_credit", type: "integer", nullable: true)]
    #[Assert\NotBlank(message: 'The credit identifier is mandatory')]
    private ?int $idCredit;

    #[ORM\Column(name: "nature_garantie", type: "string", length: 0, nullable: false)]
    #[Assert\NotBlank(message: 'The nature of the guarantee is mandatory')]
    #[Assert\Choice(choices: ['Maison', 'Voiture', 'Terrain', 'Local Commercial'], message: 'La nature de la garantie doit être parmi les valeurs proposées')]
    private ?string $natureGarantie = null;

    #[ORM\Column(name: "Valeur_Garantie", type: "float", precision: 10, scale: 0, nullable: true)]
    #[Assert\NotBlank(message: 'The value of the guarantee is mandatory')]
    #[Assert\Positive(message: 'The value of the guarantee must be positive')]
    private ?float $valeurGarantie;

    #[ORM\Column(name: "preuve", type: "string", length: 255, nullable: true)]

    private ?string $preuve;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Credit", inversedBy="garantie", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_credit", referencedColumnName="id_credit")
     */
    private $credit;

    public function getIdGarantie(): ?int
    {
        return $this->idGarantie;
    }

    public function getIdCredit(): ?int
    {
        return $this->idCredit;
    }

    public function setIdCredit(?int $idCredit): static
    {
        $this->idCredit = $idCredit;
        return $this;
    }

    public function getNatureGarantie(): ?string
    {
        return $this->natureGarantie;
    }

    public function setNatureGarantie(?string $natureGarantie): static
    {
        $this->natureGarantie = $natureGarantie;
        return $this;
    }

    public function getValeurGarantie(): ?float
    {
        return $this->valeurGarantie;
    }

    public function setValeurGarantie(?float $valeurGarantie): static
    {
        $this->valeurGarantie = $valeurGarantie;
        return $this;
    }

    public function getPreuve(): ?string
    {
        return $this->preuve;
    }

    public function setPreuve(string $preuve): self
    {
        $this->preuve = $preuve;

        return $this;
    }

    /**
     * Get the value of credit
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set the value of credit
     *
     * @return  self
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    public function __construct()
    {
        $this->natureGarantie = ''; // Set a default value here
    }
}
