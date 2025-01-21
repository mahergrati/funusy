<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SignaleRepository;
use Doctrine\DBAL\Types\Types;
use DateTimeInterface;
use DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;


#[ORM\Entity(repositoryClass: SignaleRepository::class)]
class Signale
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_signal", type: "integer", nullable: false)]
    private ?int $idSignal;

    #[ORM\Column(name: "date_signal", type: "date", nullable: false)]
    private ?DateTimeInterface $dateSignal;

    #[ORM\Column(name: "description", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: " Description comment cannot be blank")]
    private ?string $description = null;
    #[ORM\ManyToOne(targetEntity: Commentaire::class)]
    #[ORM\JoinColumn(name: "id_commentaire", referencedColumnName: "id_commentaire")]
    private ?Commentaire $idCommentaire;

    public function getIdSignal(): ?int
    {
        return $this->idSignal;
    }

    public function getDateSignal(): ?\DateTimeInterface
    {
        return $this->dateSignal;
    }

    public function setDateSignal(\DateTimeInterface $dateSignal): static
    {
        $this->dateSignal = $dateSignal;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        if ($description !== null) {
            $this->description = $description;
        }
        return $this;
    }


    public function setEtatSignal(bool $etatSignal): static
    {
        $this->etatSignal = $etatSignal;
        return $this;
    }

    public function getIdCommentaire(): ?Commentaire
    {
        return $this->idCommentaire;
    }

    public function setIdCommentaire(?Commentaire $idCommentaire): static
    {
        $this->idCommentaire = $idCommentaire;
        return $this;
    }
    public function __construct()
    {
        // Initialisation facultative de la propriété description
        $this->description = '';
    }
}
