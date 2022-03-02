<?php

namespace App\Entity;

use App\Repository\ReservationvoyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationvoyRepository::class)
 */
class Reservationvoy
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
    private $date_reser_voy;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="resvoya")
     */
    private $voyage;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="reservationvoys")
     */
    private $id_client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReserVoy(): ?\DateTimeInterface
    {
        return $this->date_reser_voy;
    }

    public function setDateReserVoy(\DateTimeInterface $date_reser_voy): self
    {
        $this->date_reser_voy = $date_reser_voy;

        return $this;
    }

    public function getVoyage(): ?Voyage
    {
        return $this->voyage;
    }

    public function setVoyage(?Voyage $voyage): self
    {
        $this->voyage = $voyage;

        return $this;
    }

    public function getIdClient(): ?Utilisateur
    {
        return $this->id_client;
    }

    public function setIdClient(?Utilisateur $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }
}
