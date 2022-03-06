<?php

namespace App\Entity;

use App\Repository\CampingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CampingRepository::class)
 */
class Camping
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="champ obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="champ obligatoire")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="champ obligatoire")
      * @Assert\Length(
     *      min = 10,
     *      max = 500,
     *      minMessage = "la description doit comporter au moins 10 caractères",
     *      maxMessage = "la description ne peut pas dépasser 500 caractères"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *  @Assert\Positive(message ="nombre doit etre positive")
     */
    private $nb_place;

    /**
     * @ORM\Column(type="float", nullable=true)
     *  @Assert\Positive(message ="prix doit etre positive")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=ReservationCamp::class, mappedBy="camping")
     */
    private $reservation;





    public function __construct()
    {
        $this->res = new ArrayCollection();
        $this->reservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nb_place;
    }

    public function setNbPlace(?int $nb_place): self
    {
        $this->nb_place = $nb_place;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }





    public function __toString() {
        return $this->lieu;
    }

    /**
     * @return Collection|ReservationCamp[]
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(ReservationCamp $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation[] = $reservation;
            $reservation->setCamping($this);
        }

        return $this;
    }

    public function removeReservation(ReservationCamp $reservation): self
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getCamping() === $this) {
                $reservation->setCamping(null);
            }
        }

        return $this;
    }






}
