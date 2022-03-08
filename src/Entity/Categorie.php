<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups("Event")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Groups("Event")
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="categorie", orphanRemoval=true)

     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups("Event")
     *
     */
    private $image;


    public function __construct()
    {
        $this->event = new ArrayCollection();
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

    /**
     * @return Collection|event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setCategorie($this);
        }

        return $this;
    }

    public function removeEvent(event $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCategorie() === $this) {
                $event->setCategorie(null);
            }
        }

        return $this;
    }


    public function __toString() {
        return $this->nom;
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
}
