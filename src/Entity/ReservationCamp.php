<?php

namespace App\Entity;

use App\Repository\ReservationCampRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationCampRepository::class)
 */
class ReservationCamp
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_reser;

    /**
     * @ORM\ManyToOne(targetEntity=Camping::class, inversedBy="res")
     */
    private $camping;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $msg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idcamp;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReser(): ?\DateTimeInterface
    {
        return $this->date_reser;
    }

    public function setDateReser(?\DateTimeInterface $date_reser): self
    {
        $this->date_reser = $date_reser;

        return $this;
    }

    public function getCamping(): ?Camping
    {
        return $this->camping;
    }

    public function setCamping(?Camping $camping): self
    {
        $this->camping = $camping;

        return $this;
    }



    public function getMsg(): ?string
    {
        return $this->msg;
    }

    public function setMsg(?string $msg): self
    {
        $this->msg = $msg;

        return $this;
    }

    public function getIdcamp(): ?int
    {
        return $this->idcamp;
    }

    public function setIdcamp(?int $idcamp): self
    {
        $this->idcamp = $idcamp;

        return $this;
    }


}
