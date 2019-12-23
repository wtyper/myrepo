<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $locale;
    public function getLocale()
    {
        return $this->locale;
    }
    /**
     * @param $locale
     */
    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }
}