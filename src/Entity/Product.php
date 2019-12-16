<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Command\ImportProductFromCsvCommand;
use Gedmo\Mapping\Annotation as Gedmo;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $dateOfCreation;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $dateOfLastModification;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductCategory", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productCategory;

    private $productData;

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
        return $this->dateOfCreation;
    }

    public function setDateOfCreation(?\DateTimeInterface $dateOfCreation): self
    {
        $this->dateOfCreation = $dateOfCreation;
        return $this;
    }

    public function getDateOfLastModification(): ?\DateTimeInterface
    {
        return $this->dateOfLastModification;
    }

    public function setDateOfLastModification(?\DateTimeInterface $dateOfLastModification): self
    {
        $this->dateOfLastModification = $dateOfLastModification;
        return $this;
    }

    public function getProductCategory(): ?ProductCategory
    {
        return $this->productCategory;
    }

    /**
     * @param ProductCategory|object|null $productCategory
     * @return Product
     */
    public function setProductCategory(?ProductCategory $productCategory): self
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    public function setProductData($name, $description, $productCategory, $dateOfLastModification){
        $this->setName($name);
        $this->setDescription($description);
        $this->setProductCategory($productCategory);
        $this->setDateOfLastModification($dateOfLastModification);
    }
}
