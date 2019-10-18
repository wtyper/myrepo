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
 * @ORM\Column(type="datetime")
 */
private $Date_of_creation;
/**
 * @ORM\Column(type="datetime")
 */
private $Date_of_las_modification;

public function getId()
{
return $this->id;
}
}
?>
