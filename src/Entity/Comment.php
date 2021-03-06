<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable="true")
     * @Assert\NotBlank(message="Comment is required")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poster;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getForum(): ?Topic
    {
        return $this->forum;
    }

    public function setForum(?Topic $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getPoster(): ?Utilisateur
    {
        return $this->poster;
    }

    public function setPoster(?Utilisateur $poster): self
    {
        $this->poster = $poster;

        return $this;
    }
}
