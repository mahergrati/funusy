<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompteRepository;

#[ORM\Entity(repositoryClass: CompteRepository::class)]
class Compte
{
    // Define primary key with the 'rib' attribute
    #[ORM\Id]
    #[ORM\Column(name: "rib", type: "string", length: 20, nullable: false)]
    private string $rib;
    

    // Define 'solde' attribute representing the balance of the account
    #[ORM\Column(name: "solde", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $solde;

    // Define 'date_ouverture' attribute representing the opening date of the account
    #[ORM\Column(name: "date_ouverture", type: "date", nullable: false)]
    private \DateTimeInterface $dateOuverture;

    // Define 'type_compte' attribute representing the type of the account
    #[ORM\Column(name: "type_compte", type: "string", length: 255, nullable: false)]
    private string $typeCompte;

    #[ORM\Column(name: "id_user", type: "integer", nullable: true)]
    private ?int $id_user;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")]
    private ?User $User;  

    #[ ORM\OneToMany(targetEntity:CarteBancaire::class, mappedBy:"rib")]
  private $cartesBancaires;
    
    public function setRib(string $rib): static
{
    $this->rib = $rib;

    return $this;
}

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): static
    {
        $this->solde = $solde;
        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(\DateTimeInterface $dateOuverture): static
    {
        $this->dateOuverture = $dateOuverture;
        return $this;
    }

    public function getTypeCompte(): ?string
    {
        return $this->typeCompte;
    }

    public function setTypeCompte(string $typeCompte): static
    {
        $this->typeCompte = $typeCompte;
        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $idUser): static
    {
        $this->id_user = $idUser;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }
    public function setUser(?User $user): static
    {
        $this->User = $user; 
        return $this;
    }
    public function getCartesBancaires()
    {
        return $this->cartesBancaires;
    }
    public function __construct()
    {
        // Initialize the id_user property here
        $this->id_user = null; // Or set it to a default value if appropriate
    }
    public function __toString(): string
    {
        return $this->getRib(); 
    }

}
