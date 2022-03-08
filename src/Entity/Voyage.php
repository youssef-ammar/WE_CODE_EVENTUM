<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoyageRepository::class)
 */
class Voyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut_voy;

    /**
     * @ORM\Column(type="date")
     *

     */
    private $date_fin_voy;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *@Assert\Length(min=10,max=254,minMessage="minimum 10 caracteres", maxMessage="max 255 caracteres")
     */
    private $descri_voy;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank

     */

    private $destination_voy;

    /**
     * @ORM\Column(type="integer")
     *@Assert\Positive
     */
    private $nbre_place_voy;

    /**
     * @ORM\Column(type="string", length=255,nullable="true")



     */
    private $image_voy;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private $prix_voy;

    /**
     * @ORM\OneToMany(targetEntity=Reservationvoy::class, mappedBy="comment")
     *
     */
    private $resvoya;

    public function __construct()
    {
        $this->resvoya = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutVoy(): ?\DateTimeInterface
    {
        return $this->date_debut_voy;
    }

    public function setDateDebutVoy(\DateTimeInterface $date_debut_voy): self
    {
        $this->date_debut_voy = $date_debut_voy;

        return $this;
    }

    public function getDateFinVoy(): ?\DateTimeInterface
    {
        return $this->date_fin_voy;
    }

    public function setDateFinVoy(\DateTimeInterface $date_fin_voy): self
    {
        $this->date_fin_voy = $date_fin_voy;

        return $this;
    }

    public function getDescriVoy(): ?string
    {
        return $this->descri_voy;
    }

    public function setDescriVoy(string $descri_voy): self
    {
        $this->descri_voy = $descri_voy;

        return $this;
    }

    public function getDestinationVoy(): ?string
    {
        return $this->destination_voy;
    }

    public function setDestinationVoy(string $destination_voy): self
    {
        $this->destination_voy = $destination_voy;

        return $this;
    }

    public function getNbrePlaceVoy(): ?int
    {
        return $this->nbre_place_voy;
    }

    public function setNbrePlaceVoy(int $nbre_place_voy): self
    {
        $this->nbre_place_voy = $nbre_place_voy;

        return $this;
    }

    public function getImageVoy(): ?string
    {
        return $this->image_voy;
    }

    public function setImageVoy(string $image_voy): self
    {
        $this->image_voy = $image_voy;

        return $this;
    }

    public function getPrixVoy(): ?float
    {
        return $this->prix_voy;
    }

    public function setPrixVoy(float $prix_voy): self
    {
        $this->prix_voy = $prix_voy;

        return $this;
    }

    /**
     * @return Collection|Reservationvoy[]
     */
    public function getResvoya(): Collection
    {
        return $this->resvoya;
    }

    public function addResvoya(Reservationvoy $resvoya): self
    {
        if (!$this->resvoya->contains($resvoya)) {
            $this->resvoya[] = $resvoya;
            $resvoya->setVoyage($this);
        }

        return $this;
    }

    public function removeResvoya(Reservationvoy $resvoya): self
    {
        if ($this->resvoya->removeElement($resvoya)) {
            // set the owning side to null (unless already changed)
            if ($resvoya->getVoyage() === $this) {
                $resvoya->setVoyage(null);
            }
        }

        return $this;
    }


}
