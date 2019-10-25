<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateOfCreation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateOfLastModification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getDateOfCreation(): ?\DateTimeInterface
    {
        return $this->DateOfCreation;
    }

    public function setDateOfCreation(\DateTimeInterface $DateOfCreation): self
    {
        $this->DateOfCreation = $DateOfCreation;

        return $this;
    }

    public function getDateOfLastModification(): ?\DateTimeInterface
    {
        return $this->DateOfLastModification;
    }

    public function setDateOfLastModification(\DateTimeInterface $DateOfLastModification): self
    {
        $this->DateOfLastModification = $DateOfLastModification;

        return $this;
    }
}
