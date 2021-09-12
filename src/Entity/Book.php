<?php
/**
 * Book entity.
 */

namespace App\Entity;

use DateTimeInterface;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Book.
 * @ORM\Entity(repositoryClass=BookRepository::class)
 *
 * @ORM\Table(name="book")
 *
 *
 */
class Book
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
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     *     )
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="255",
     *     )
     *
     */
    private $title;

    /**
     * Author.
     *
     * @var Author  Author
     *
     * @ORM\ManyToOne(
     *     targetEntity=Author::class,
     *     inversedBy="book"
     * )
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

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
     * @Assert\DateTime
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Category.
     *
     * @var Category Category
     *
     * @ORM\ManyToOne(
     *     targetEntity=Category::class,
     *     inversedBy="book")
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="book")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="book")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $comments;
//
//    /**
//     * @var string
//     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="book")
//     */
//    private $comment;

    /**
     * Book constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }


//    /**
//     * Category.
//     *
//     * @var Category Category
//     *
//     * @ORM\ManyToOne(
//     *     targetEntity="App\Entity\Category",
//     *     inversedBy="book",
//     * )
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $category;

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
     * Getter for title.
     *
     * @return string|null  Title
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
     * Getter for Author.
     *
     * @return Author|null  Author
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * Setter for Author.
     *
     * @param Author|null $author Author
     */
    public function setAuthor(?author $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * Getter for category.
     *
     * @return Category|null Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for category.
     *
     * @param Category|null $category Category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }
    /**
     * Transform to string
     *
     * @return string
     */

    public function __toString()
    {
        return (string) $this->getId();
    }

//    public function getCategory(): ?Category
//    {
//        return $this->category;
//    }
//
//    public function setCategory(?Category $category): self
//    {
//        $this->category = $category;
//
//        return $this;
//    }

    /**
     * Getter for tags.
     *
     * @return Collection|Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to collection.
     *
     * @param Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove tag from collection.
     *
     * @param Tag $tag  Tag entity.
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }

//    /**
//     * @return Collection|Comment[]
//     */
//    public function getComment(): Collection
//    {
//        return $this->comment;
//    }
//
//    /**
//     * @param Comment $comment
//     * @return $this
//     */
//    public function addComment(Comment $comment): self
//    {
//        if (!$this->comment->contains($comment)) {
//            $this->comment[] = $comment;
//            $comment->setBook($this);
//        }
//
//        return $this;
//    }
//
//    /**
//     * @param Comment $comment
//     * @return $this
//     */
//    public function removeComment(Comment $comment): self
//    {
//        if ($this->comment->removeElement($comment)) {
//            // set the owning side to null (unless already changed)
//            if ($comment->getBook() === $this) {
//                $comment->setBook(null);
//            }
//        }
//
//        return $this;
//    }

/**
 * @return string
 */
public function getComments(): Collection
{
    return $this->comments;
}

public function addComment(Comment $comment): self
{
    if (!$this->comments->contains($comment)) {
        $this->comments[] = $comment;
        $comment->setBook($this);
    }

    return $this;
}

public function removeComment(Comment $comment): self
{
    if ($this->comments->removeElement($comment)) {
        // set the owning side to null (unless already changed)
        if ($comment->getBook() === $this) {
            $comment->setBook(null);
        }
    }

    return $this;
}
}
