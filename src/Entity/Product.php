<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
* @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
*/
class Product
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
private $Name;
/**
 * @ORM\Column(type="text")
     */
private $Description;
/**
 * @ORM\Column(type="text")
 */
private $Date_of_creation;
/**
 * @ORM\Column(type="text")
 */
private $Date_of_last_modification;


    /**
     * Get id
     *
     * @return id $id
     */
public function getid()
    {
        return $this->id;
    }

    /**
     * Set Name
     *
     * @param string $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }
    /**
 * Get Name
 *
 * @return string $Name
 */
public function getName()
    {
        return $this->Name;
    }

    /**
     * Set Description
     *
     * @param string $Description
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
    }
    /**
     * Get Description
     *
     * @return string $Description
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Set Date_of_creation
     *
     * @param string $Date_of_creation
     */
    public function setDate_of_creation($Date_of_creation)
    {
        $this->Date_of_creation = $Date_of_creation;
    }
    /**
     * Get Date_of_creation
     *
     * @return string $Date_of_creation
     */
    public function getDate_of_creation()
    {
        return $this->Date_of_creation;
    }

    /**
     * Set Date_of_last_modification
     *
     * @param string $Date_of_last_modification
     */
    public function setDate_of_last_modification($Date_of_last_modification)
    {
        $this->Date_of_last_modification = $Date_of_last_modification;
    }
    /**
     * Get Date_of_last_modification
     *
     * @return string $Date_of_last_modification
     */
    public function getDate_of_last_modification()
    {
        return $this->Date_of_last_modification;
    }
}
?>
