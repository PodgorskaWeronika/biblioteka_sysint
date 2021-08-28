<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 *
 * @UniqueEntity(fields={"title"})
 */
class Tag
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     *
     * @Gedmo\Slug(fields={"title"})
     */
    private $code;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $title;

    /**
     * Tasks.
     *
     * @var ArrayCollection|Task[] Tasks
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Task",
     *     mappedBy="tags"
     * )
     *
     */
    private $tasks;

    /**
     * Tags.
     *
     * @var Array Tags
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Task",
     *     mappedBy="tags"
     * )
     *
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Book::class, mappedBy="tags")
     */
    private $book;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
//        $this->tags = new ArrayCollection();
$this->book = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Created At.
     *
     * @return DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at.
     *
     * @param DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Updated at.
     *
     * @return DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for Code.
     *
     * @return string|null Code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Setter for Code.
     *
     * @param string $code Code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for tasks.
     *
     * @return \Doctrine\Common\Collections\Collection|Task[] Tasks collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }
    /**
     * Getter for tags.
     *
     * @return Tag Tag collection
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * Setter for Tag.
     *
     * @param string $tags Tags
     */
    public function setTags(string $tags): void
    {
        $this->title = $tags;
    }
    /**
     * Add task to collection.
     *
     * @param Task $task Task entity
     */
    public function addTask(Task $task): void
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->addTag($this);
        }
    }

    /**
     * Remove task from collection.
     *
     * @param \App\Entity\Task $task Task entity
     */
    public function removeTask(Task $task): void
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            $task->removeTag($this);
        }
    }

//    /**
//     * Add tag to collection.
//     *
//     * @param Tag $tag Tag entity
//     */
//        public function addTag(Tag $tag): void
//        {
//            if (!$this->tags->contains($tag)) {
//                $this->tags[] = $tag;
//                $tag->addTask($this);
//            }
//        }
//
//    /**
//     * Remove task from collection.
//     *
//     * @param \App\Entity\Task $task Task entity
//     */
//    public function removeTask(Task $task): void
//    {
//        if ($this->tasks->contains($task)) {
//            $this->tasks->removeElement($task);
//            $task->removeTag($this);
//        }
//    }

/**
 * @return Collection|Book[]
 */
public function getBook(): Collection
{
    return $this->book;
}

public function addBook(Book $book): self
{
    if (!$this->book->contains($book)) {
        $this->book[] = $book;
        $book->addTag($this);
    }

    return $this;
}

public function removeBook(Book $book): self
{
    if ($this->book->removeElement($book)) {
        $book->removeTag($this);
    }

    return $this;
}
}