<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\Column(name: "id_commentaire", type: Types::INTEGER, nullable: false)]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idCommentaire;

    #[ORM\Column(name: "contenue", type: Types::STRING, length: 255, nullable: false)]
    #[Assert\NotBlank(message: " content comment cannot be blank")]
    private ?string $contenue;

    #[ORM\Column(name: "date_commentaire", type: Types::DATE_MUTABLE, nullable: false)]
    private ?DateTimeInterface $dateCommentaire;

    #[ORM\ManyToOne(targetEntity: Projet::class)]
    #[ORM\JoinColumn(name: "id_projet", referencedColumnName: "id_projet")]
    #[Assert\NotBlank(message: " you must select a project ")]
    private ?Projet $idProjet;

    public function getIdCommentaire(): ?int
    {
        return $this->idCommentaire;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(?string $contenue): self
    {
        $this->contenue = $contenue;
        return $this;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(?\DateTimeInterface $dateCommentaire): self
    {
        $this->dateCommentaire = $dateCommentaire;
        return $this;
    }

    public function getIdProjet(): ?Projet
    {
        return $this->idProjet;
    }

    public function setIdProjet(?Projet $idProjet): self
    {
        $this->idProjet = $idProjet;
        return $this;
    }
    public function __toString()
    {
        return sprintf(
            'Commentaire #%d - Contenue: %s, Date: %s, nomProjet: %s',
            $this->idCommentaire,
            $this->contenue,
            $this->dateCommentaire->format('d-m-Y'),
            $this->idProjet ? $this->idProjet->getNomProjet() : 'Aucun Projet'
        );
    }
    public function __construct()
    {
        $this->dateCommentaire = new DateTime(); // Initialise dateCredit avec la date locale actuelle
    }
}