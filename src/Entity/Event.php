<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Groups("Event")
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Groups("Event")


     */

    private $date_debut;

    /**
     * @ORM\Column(type="date", nullable=true)


     *  @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Groups("Event")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Groups("Event")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string" , nullable=true)

     * @Assert\Length(
     *      min = 10,
     *      max = 1000,
     *      minMessage = "la description doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "la description ne peut pas dépasser {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Groups("Event")
     */

    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message ="prix doit etre positive")
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Groups("Event")
     */

    private $prix;


    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="event",cascade={"persist"})
     * @Groups("Event")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="event" ,cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Groups("Event")
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }



    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setEvent($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getEvent() === $this) {
                $image->setEvent(null);
            }
        }

        return $this;
    }
}
