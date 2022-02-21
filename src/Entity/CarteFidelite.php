<?php

namespace App\Entity;

use App\Repository\CarteFideliteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=CarteFideliteRepository::class)
 */
class CarteFidelite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="numero carte is required")
     */
    private $numFidelite;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Range(
     *      min = "now"
     * )
     */
    private $DateAjout;

    /**
     * @ORM\Column(type="date")
     */
    private $DateExpiration;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, cascade={"persist", "remove"},orphanRemoval=true)
     */
    private $Utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFidelite(): ?int
    {
        return $this->numFidelite;
    }

    public function setNumFidelite(int $numFidelite): self
    {
        $this->numFidelite = $numFidelite;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->DateAjout;
    }

    public function setDateAjout(?\DateTimeInterface $DateAjout): self
    {
        $this->DateAjout = $DateAjout;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->DateExpiration;
    }

    public function setDateExpiration(?\DateTimeInterface $DateExpiration): self
    {
        $this->DateExpiration = $DateExpiration;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): self
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }
}
