<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 * @Vich\Uploadable
 */
class Review
{
    use CreatedUpdatedTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(max = 100)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     */
    private $note;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min = 5, max = 100)
     */
    private $title;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="review_photo", fileNameProperty="photo", originalName="photoOriginalName", mimeType="format")
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes = {"image/jpeg", "image/png"}
     * )
     * @var File
     */
    private $photoFile;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var string
     */
    private $photoOriginalName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=25, nullable=true)
     */
    private $format;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param integer $product
     * @return Review
     */
    public function setProduct(int $product)
    {
        $this->product = $product;
        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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

    /**
     * @return File
     */
    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    /**
     * @param File $photoFile
     * @return Review
     */
    public function setPhotoFile(File $photoFile): Review
    {
        $this->photoFile = $photoFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     * @return Review
     */
    public function setPhoto(string $photo): Review
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoOriginalName(): ?string
    {
        return $this->photoOriginalName;
    }

    /**
     * @param string $photoOriginalName
     * @return Review
     */
    public function setPhotoOriginalName(string $photoOriginalName): Review
    {
        $this->photoOriginalName = $photoOriginalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return Review
     */
    public function setFormat(string $format): Review
    {
        $this->format = $format;
        return $this;
    }



}
