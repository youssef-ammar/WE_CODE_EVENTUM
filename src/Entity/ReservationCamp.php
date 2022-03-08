<?php

namespace App\Entity;

use App\Repository\ReservationCampRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private $dateRes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\Length(
     *      min = 10,
     *      max = 500,
     *      minMessage = "la description doit comporter au moins 10 caractères",
     *      maxMessage = "la description ne peut pas dépasser 500 caractères"
     * )
     */
    private $msg;

    /**
     * @ORM\ManyToOne(targetEntity=Camping::class, inversedBy="reservation")
     */
    private $camping;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->dateRes;
    }

    public function setDateRes(?\DateTimeInterface $dateRes): self
    {
        $this->dateRes = $dateRes;

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

    public function getCamping(): ?Camping
    {
        return $this->camping;
    }

    public function setCamping(?Camping $camping): self
    {
        $this->camping = $camping;

        return $this;
    }
}
