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
    private $date_of_creation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_of_last_modification;

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

    public function getDate_of_creation(): ?\DateTimeInterface
    {
        return $this->date_of_creation;
    }

    public function setDate_of_creation(\DateTimeInterface $date_of_creation): self
    {
        $this->date_of_creation = $date_of_creation;

        return $this;
    }

    public function getDate_of_last_modification(): ?\DateTimeInterface
    {
        return $this->date_of_last_modification;
    }

    public function setDate_of_last_modification(\DateTimeInterface $date_of_last_modification): self
    {
        $this->date_of_last_modification = $date_of_last_modification;

        return $this;
    }
}
