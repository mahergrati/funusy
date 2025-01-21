<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Repository\CreditRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_credit", type: "integer", nullable: false)]
    private ?int $idCredit;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le montant du crédit est obligatoire')]
    #[Assert\Type(type: 'float', message: 'Le montant du crédit doit être un nombre')]
    #[Assert\Positive(message: 'Le montant du crédit doit être positif')]
    private ?float $montantCredit;

    #[ORM\Column(name: "duree_credit", type: "integer", nullable: false)]
    #[Assert\NotBlank(message: 'La durée du crédit est obligatoire')]
    #[Assert\Positive(message: 'La durée du crédit doit être positive')]
    private ?int $dureeCredit;

    #[ORM\Column(name: "date_credit", type: "date", nullable: false)]
    #[Assert\NotBlank(message: 'La date du crédit est obligatoire')]
    private ?DateTimeInterface $dateCredit;

    #[ORM\Column(name: "taux_credit", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: 'Le taux du crédit est obligatoire')]
    #[Assert\Positive(message: 'Le taux du crédit doit être positif')]
    private ?float $tauxCredit;

    #[ORM\Column(name: "status", type: "string", length: 255, nullable: true, options: ["default" => "Non traité"])]
    #[Assert\Choice(choices: ['Accepted', 'Rejected', 'Non traité'], message: 'Le statut doit être parmi les valeurs proposées')]
    private ?string $status = 'Non traité';

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")]
    #[Assert\NotBlank(message: 'L\'utilisateur est obligatoire')]
    private ?User $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Garantie", mappedBy="credit", cascade={"persist", "remove"})
     */
    private $garantie;

    public function getIdCredit(): ?int
    {
        return $this->idCredit;
    }

    public function getMontantCredit(): ?float
    {
        return $this->montantCredit;
    }

    public function setMontantCredit(float $montantCredit): static
    {
        $this->montantCredit = $montantCredit;
        return $this;
    }

    public function getDureeCredit(): ?int
    {
        return $this->dureeCredit;
    }

    public function setDureeCredit(int $dureeCredit): static
    {
        $this->dureeCredit = $dureeCredit;
        return $this;
    }

    public function getDateCredit(): ?\DateTimeInterface
    {
        return $this->dateCredit;
    }

    public function setDateCredit(\DateTimeInterface $dateCredit): static
    {
        $this->dateCredit = $dateCredit;
        return $this;
    }

    public function getTauxCredit(): ?float
    {
        return $this->tauxCredit;
    }

    public function setTauxCredit(float $tauxCredit): static
    {
        $this->tauxCredit = $tauxCredit;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the value of garantie
     */
    public function getGarantie()
    {
        return $this->garantie;
    }

    /**
     * Set the value of garantie
     *
     * @return  self
     */
    public function setGarantie($garantie)
    {
        $this->garantie = $garantie;

        // Lier la garantie à ce crédit
        if ($garantie !== null) {
            $garantie->setCredit($this);
        }

        return $this;
    }

    public function __toString()
    {
        return sprintf(
            'Credit #%d - Montant: %s, Durée: %d, Date: %s, Taux: %s, Statut: %s, Utilisateur: %s',
            $this->idCredit,
            $this->montantCredit,
            $this->dureeCredit,
            $this->dateCredit->format('d-m-Y'),
            $this->tauxCredit,
            $this->status,
            $this->user ? $this->user->getNomUser() : 'Aucun utilisateur'
        );
    }

    public function __construct()
    {
        $this->dateCredit = new DateTime(); // Initialise dateCredit avec la date locale actuelle
        $this->status = 'Non traité';
    }
}
