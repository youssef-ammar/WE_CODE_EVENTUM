<?php

namespace App\Entity;

use App\Repository\BookmarkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookmarkRepository::class)
 */
class Bookmark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Topic::class, inversedBy="marks")
     */
    private $Topicmark;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $userBook;

    public function __construct()
    {
        $this->Topicmark = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /*
     *

    public function getTopic(): Collection
    {
        return 0;

    }
     */
    /**
     * @return Collection<int, Topic>
     */
    public function getTopicmark() : Collection
    {
        return $this->Topicmark;
    }
    public function getTopic (){

        $this->Topicmark;
    }

    public function addTopicmark(Topic $topicmark): self
    {
        if (!$this->Topicmark->contains($topicmark)) {
            $this->Topicmark[] = $topicmark;
        }

        return $this;
    }

    public function removeTopicmark(Topic $topicmark): self
    {
        $this->Topicmark->removeElement($topicmark);

        return $this;
    }

    public function getUserBook(): ?string
    {
        return $this->userBook;
    }

    public function setUserBook(string $userBook): self
    {
        $this->userBook = $userBook;

        return $this;
    }
}
