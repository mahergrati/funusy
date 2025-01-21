<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\TransactionRepository;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
     #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_transaction", type: "integer", nullable: false)]
    private ?int $idTransaction;

    #[ORM\Column(name: "montant_transaction", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $montantTransaction;

    #[ORM\Column(name: "date_transaction", type: "date", nullable: false)]
    private \DateTime $dateTransaction;

    #[ORM\Column(name: "destination", type: "string", length: 20, nullable: false)]
    private string $destination;

    #[ORM\Column(name: "type_transaction", type: "string", length: 20, nullable: false)]
    private ?string $typeTransaction;

    #[ORM\ManyToOne(targetEntity: Compte::class)]
    #[ORM\JoinColumn(name: "rib", referencedColumnName: "rib")]
    private ?Compte $rib;

    public function getIdTransaction(): ?int
    {
        return $this->idTransaction;
    }

    public function getMontantTransaction(): ?float
    {
        return $this->montantTransaction;
    }

    public function setMontantTransaction(float $montantTransaction): static
    {
        $this->montantTransaction = $montantTransaction;
        return $this;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(\DateTimeInterface $dateTransaction): static
    {
        $this->dateTransaction = $dateTransaction;
        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;
        return $this;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(?string $typeTransaction): static
    {
        $this->typeTransaction = $typeTransaction;
        return $this;
    }

    public function getRib(): ?Compte
    {
        return $this->rib;
        
    }

    public function setRib(?Compte $rib): static
    {
        $this->rib = $rib;
        return $this;
    }
    
    public function __construct()

    {

        $this->dateTransaction = new \DateTime();

        $compte = new Compte();

         
 

    }
}
