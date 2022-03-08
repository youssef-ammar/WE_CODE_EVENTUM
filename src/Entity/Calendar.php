<?php

namespace App\Entity;

use App\Repository\CalendarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CalendarRepository::class)
 */
class Calendar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $backgroudcolor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $yes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $textcolor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allday;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="calender",cascade={"persist"})
     *  @ORM\JoinColumn(onDelete="CASCADE")
     *
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="calendar")
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

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

    public function getBackgroudcolor(): ?string
    {
        return $this->backgroudcolor;
    }

    public function setBackgroudcolor(?string $backgroudcolor): self
    {
        $this->backgroudcolor = $backgroudcolor;

        return $this;
    }

    public function getYes(): ?string
    {
        return $this->yes;
    }

    public function setYes(?string $yes): self
    {
        $this->yes = $yes;

        return $this;
    }

    public function getTextcolor(): ?string
    {
        return $this->textcolor;
    }

    public function setTextcolor(?string $textcolor): self
    {
        $this->textcolor = $textcolor;

        return $this;
    }

    public function getAllday(): ?bool
    {
        return $this->allday;
    }

    public function setAllday(?bool $allday): self
    {
        $this->allday = $allday;

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

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
