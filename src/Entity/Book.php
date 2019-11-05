<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
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
     * @ORM\Column(type="text")
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $genre;

    /**
     * @ORM\Column(type="date")
     */
    private $yearOfPublishment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryOfPublishment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $availability;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOfCreate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOfUpdate;


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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getYearOfPublishment(): ?\DateTimeInterface
    {
        return $this->yearOfPublishment;
    }

    public function setYearOfPublishment(\DateTimeInterface $yearOfPublishment): self
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

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(string $availability): self
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
}
