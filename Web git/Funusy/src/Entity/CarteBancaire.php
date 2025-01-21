<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarteBancairetRepository;

#[ORM\Entity(repositoryClass: CarteBancairetRepository::class)]
class CarteBancaire
{
    #[ORM\Id]
    #[ORM\Column(name: "num_carte", type: "string", length: 19, nullable: false)]
    private string $numCarte;

    #[ORM\Column(name: "date_exp", type: "date", nullable: true)]
    private \DateTimeInterface $dateExp;

    #[ORM\Column(name: "code", type: "integer", nullable: false)]
    private int $code;

    #[ORM\Column(name: "CVV2", type: "integer", nullable: false)]
    private int $cvv2;

    

    #[ORM\Column(name: "rib", type: "string", length: 20, nullable: false)]

    private ?string $rib;
    
    public function setRib(?string $rib): void
    {
        $this->rib = $rib;
    
        
    }
    public function getRib(): ?string
    {
        return $this->rib;
    }
    


    public function getNumCarte(): ?string
    {
        return $this->numCarte;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->dateExp;
    }

    public function setDateExp(\DateTimeInterface $dateExp): static
    {
        $this->dateExp = $dateExp;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCvv2(): ?int
    {
        return $this->cvv2;
    }

    public function setCvv2(int $cvv2): static
    {
        $this->cvv2 = $cvv2;

        return $this;
    }

   
    
   
    public function setNumCarte(string $numCarte): static
    {
        $this->numCarte = $numCarte;

        return $this;
    }

    
  
}
