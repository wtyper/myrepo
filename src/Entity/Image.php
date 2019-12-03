<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 *  @ORM\Table(name="image")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Image(
     *     mimeTypes = { "image/png", "image/jpeg", "image/jpg" },
     *     maxSize = "1m"
     *     )
     */
    private $file;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="gallery")
     * @Assert\NotBlank
     * @ORM\JoinColumn(name="id",
     *      referencedColumnName="id",
     *      onDelete="CASCADE",nullable=false)
     */
    private $product;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFile();
    }
    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
    /**
     * @param string $file
     * @return Image
     */
    public function setFile($file): Image
    {
        if ($file) {
            $this->file = $file;
        }
        return $this;
    }


    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param mixed $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}
