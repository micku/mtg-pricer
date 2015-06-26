<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Entity
 * @ORM\Table("language")
 *
 * @ExclusionPolicy("all")
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=512)
     * @Expose
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="ForeignName", mappedBy="language")
     **/
    protected $foreignNames;

    public function __construct()
    {
        $this->foreignNames = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Language
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add foreignNames
     *
     * @param \AppBundle\Entity\ForeignName $foreignNames
     * @return Language
     */
    public function addForeignName(\AppBundle\Entity\ForeignName $foreignNames)
    {
        $this->foreignNames[] = $foreignNames;

        return $this;
    }

    /**
     * Remove foreignNames
     *
     * @param \AppBundle\Entity\ForeignName $foreignNames
     */
    public function removeForeignName(\AppBundle\Entity\ForeignName $foreignNames)
    {
        $this->foreignNames->removeElement($foreignNames);
    }

    /**
     * Get foreignNames
     *
     * @return \AppBundle\Entity\ForeignName
     */
    public function getForeignNames()
    {
        return $this->foreignNames;
    }
}
