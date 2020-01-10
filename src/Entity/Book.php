<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     *
     *  @ORM\Column(type="integer")
     */
    private $yearOfPublishment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryOfPublishment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $availability;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $dateOfCreate;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $dateOfUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     * @ORM\JoinColumn(name="author_id",
     *      referencedColumnName="id",
     *      onDelete="CASCADE",
     *      nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Genre", inversedBy="books")
     * @ORM\JoinColumn(name="genre_id",
     *      referencedColumnName="id",
     *      onDelete="CASCADE",
     *      nullable=false)
     */
    private $genre;

    /**
     * @var @ORM\Column(type="string", nullable=true)
     */
    private $cover;

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

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getYearOfPublishment(): ?int
    {
        return $this->yearOfPublishment;
    }

    public function setYearOfPublishment(int $yearOfPublishment): self
    {
        $this->yearOfPublishment = $yearOfPublishment;

        return $this;
    }

    public function getCountryOfPublishment(): ?string
    {
        return $this->countryOfPublishment;
    }

    public function setCountryOfPublishment(string $countryOfPublishment): self
    {
        $this->countryOfPublishment = $countryOfPublishment;

        return $this;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getDateOfCreate(): ?\DateTimeInterface
    {
        return $this->dateOfCreate;
    }

    public function setDateOfCreate(\DateTimeInterface $dateOfCreate): self
    {
        $this->dateOfCreate = $dateOfCreate;

        return $this;
    }

    public function getDateOfUpdate(): ?\DateTimeInterface
    {
        return $this->dateOfUpdate;
    }

    public function setDateOfUpdate(\DateTimeInterface $dateOfUpdate): self
    {
        $this->dateOfUpdate = $dateOfUpdate;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @param $cover
     * @return $this
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
        return $this;
    }
    /**
     * @return Image
     */
    public function getCover()
    {
        return $this->cover;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->title,
            'description' => $this->description,
            'author' => $this->getAuthor()->getName() . ' ' . $this->getAuthor()->getLastName(),
            'genre' => $this->getGenre()->getName(),
            'countryOfPublishment' => $this->getCountryOfPublishment(),
            'yearOfPublishment' => $this->yearOfPublishment,
            'availability' => $this->availability
        ];
    }
}
