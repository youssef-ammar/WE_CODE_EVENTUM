<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=TopicRepository::class)
 */
class Topic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Title is required")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Description is required")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Cathegories is required")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=100)
     *@Assert\NotBlank(message="visibility is required")
     */
    private $public;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $share;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $bookmark;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)

     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Forum::class, inversedBy="topic")
     */
    private $forum;



    public function __construct()
    {
        $this->comment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setForum($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getForum() === $this) {
                $comment->setForum(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPublic(): ?string
    {
        return $this->public;
    }

    public function setPublic(string $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getShare(): ?string
    {
        return $this->share;
    }

    public function setShare(?string $share): self
    {
        $this->share = $share;

        return $this;
    }

    public function getBookmark(): ?string
    {
        return $this->bookmark;
    }

    public function setBookmark(string $bookmark): self
    {
        $this->bookmark = $bookmark;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }
}
