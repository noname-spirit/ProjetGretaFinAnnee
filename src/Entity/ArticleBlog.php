<?php

namespace App\Entity;

use App\Repository\ArticleBlogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile; // For $imageFile property
use Symfony\Component\Validator\Constraints as Assert;   // For validation of $imageFile

#[ORM\Entity(repositoryClass: ArticleBlogRepository::class)]
class ArticleBlog
{

    const IMAGE_PATH = '/uploads/articles';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title = null;

    // Added subTitle based on your CRUD controller example
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $subTitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    /**
     * This property holds the binary image data (BLOB).
     * It's populated from $imageFile (via processImageUpload in CRUD controller) when an image is uploaded.
     * Doctrine hydrates this as a resource from the database.
     */
    // #[ORM\Column(type: Types::BLOB, nullable: true)]
    // private mixed $image = null; // 'mixed' for PHP 8.0+ (resource from DB, string/resource when set)

    /**
     * This is NOT a mapped field, just a temporary property for the uploaded file.
     * Used by the Symfony Form (EasyAdmin) to handle the file upload.
     * @Assert\Image(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage = "Veuillez télécharger une image valide (JPG, PNG, GIF). Taille max: 5MB."
     * )
     */
    private ?UploadedFile $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Returns the image data as a string.
     * If $this->image is a resource (from DB), it reads its content.
     * If $this->image is already a string (e.g., after setImage), it returns it directly.
     */
    public function getImage(): ?string
    {
        return null;
        if (is_resource($this->image)) {
            rewind($this->image); // Ensure stream pointer is at the beginning
            $content = stream_get_contents($this->image);
            // fclose($this->image) is not needed here as Doctrine manages resources it opens.
            return $content !== false ? $content : null;
        }

        if (is_string($this->image)) {
            return $this->image;
        }

        return null;
    }

    public function getImagePath(): ?string
    {
        return self::IMAGE_PATH . '/' . this->image;
    }

    /**
     * Sets the raw image data (binary string or resource).
     * In the context of uploads, the CRUD controller will typically pass a binary string here.
     *
     * @param string|resource|null $image
     */
    // public function setImage(mixed $image): static
    // {
    //     $this->image = $image;
    //     return $this;
    // }

    /**
     * Getter for the temporary uploaded file property used by forms.
     */
    // public function getImageFile(): ?UploadedFile
    // {
    //     return $this->imageFile;
    // }

    /**
     * Setter for the temporary uploaded file property used by forms.
     *
     * @param UploadedFile|null $imageFile
     */
    public function setImageFile(?UploadedFile $imageFile = null): static
    {
        $this->imageFile = $imageFile;

        // OPTIONAL: If you have an 'updatedAt' field, it's good practice to update it here
        // when a new file is set. This ensures Doctrine registers the entity as "dirty"
        // if only the file was changed, triggering lifecycle callbacks or an update.
        // if ($this->imageFile instanceof UploadedFile && property_exists($this, 'updatedAt')) {
        //     $this->updatedAt = new \DateTimeImmutable();
        // }
        return $this;
    }

    /**
     * Helper method to get the image as a base64 encoded string,
     * suitable for embedding in <img> tags using data URIs.
     */
    // public function getImageAsBase64(): ?string
    // {
    //     $imageData = $this->getImage(); // This handles resource-to-string or direct string
    //     if ($imageData === null) {
    //         return null;
    //     }
    //     return base64_encode($imageData);
    // }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
