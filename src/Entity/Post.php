<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable()
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="postCollection")
     */
    private $categoryCollection;

    //Um Post para Varios COmentarios
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     * @ORM\OrderBy({"created_at" = "DESC"})
     */
    private $commentsCollection;

    public function __construct()
    {
        $this->categoryCollection = new ArrayCollection();
        $this->commentsCollection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param ArrayCollection $author
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCategoryCollection()
    {
        return $this->categoryCollection;
    }

    /**
     * @param ArrayCollection $categoryCollection
     */
    public function setCategoryCollection(Category $categoryCollection): self
    {
        if($this->categoryCollection->contains($categoryCollection)){
            return $this;
        }

        $this->categoryCollection[] = $categoryCollection;

        return $this;
    }

    public function getCommentsCollection(){
        return $this->commentsCollection;
    }
}
