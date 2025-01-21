<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProjetRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
 
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProjet = null;

    #[ORM\Column(name: "nom_projet", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Project name cannot be blank")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Project name must be at least {{ limit }} characters long",
        maxMessage: "Project name cannot be longer than {{ limit }} characters"
    )]
    #[Assert\Regex(pattern: '/^[a-zA-Z0-9_]+$/', message: ' nom projet ne doit contenir que des lettres, des chiffres et des tirets')]
    #[Assert\Type('string', message: ' nom projet doit être une chaîne de caractères')]
    private ?string $nomProjet = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le montant ne doit pas être vide')]
    #[Assert\Type('float', message: 'Le montant doit être un nombre')]
    #[Assert\Positive(message: 'Le montant doit être un nombre positif')]
    private ?float $montantReq = null;

    #[ORM\Column(name: "longitude", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Longitude cannot be blank")]
    private ?string $longitude;

    #[ORM\Column(name: "latitude", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Latitude cannot be blank")]
    private ?string $latitude;

    #[ORM\Column(name: "type_projet", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Project type cannot be blank")]
    private ?string $typeProjet;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La description ne doit pas être vide')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'La description doit contenir au moins 3 caractères', maxMessage: 'La description doit contenir au maximum 255 caractères')]
    #[Assert\Type('string', message: 'La description doit être une chaîne de caractères')]
    #[Assert\Regex(pattern: '/^[a-zA-Z0-9_]+$/', message: 'La description ne doit contenir que des lettres, des chiffres et des tirets')]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")] // Assuming the column name in User entity is id_user
    #[Assert\NotBlank(message: "choose a user")]
    private ?User $user;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Investissement::class)]
    private Collection $investissements;

    public function __construct()
{
    $this->investissements = new ArrayCollection();
}
public function getInvestissements(): Collection
{
    return $this->investissements;
}

public function addInvestissement(Investissement $investissement): self
{
    if (!$this->investissements->contains($investissement)) {
        $this->investissements[] = $investissement;
        $investissement->setProjet($this);
    }

    return $this;
}

public function removeInvestissement(Investissement $investissement): self
{
    if ($this->investissements->removeElement($investissement)) {
        // set the owning side to null (unless already changed)
        if ($investissement->getProjet() === $this) {
            $investissement->setProjet(null);
        }
    }

    return $this;
}
    public function getIdProjet(): ?int
    {
        return $this->idProjet;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): static
    {
        $this->nomProjet = $nomProjet;
        return $this;
    }

    public function getMontantReq(): ?float
    {
        return $this->montantReq;
    }

    public function setMontantReq(float $montantReq): static
    {
        $this->montantReq = $montantReq;
        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getTypeProjet(): ?string
    {
        return $this->typeProjet;
    }

    public function setTypeProjet(string $typeProjet): static
    {
        $this->typeProjet = $typeProjet;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
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



}
