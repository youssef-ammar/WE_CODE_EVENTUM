<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("Event")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("Event")
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="images", cascade={"remove"})
     *
     */
    private $event;

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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
    public function __toString(): string
    {
        return 'bla bla';
    }
}
