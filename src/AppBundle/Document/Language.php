<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Document(collection="language")
 *
 * @ExclusionPolicy("all")
 */
class Language
{
    /**
     * @ORM\Id
     * @Expose
     */
    protected $id;

    /**
     * @ORM\String
     * @Expose
     */
    protected $name;

    /**
     * @ORM\String
     * @Expose
     */
    protected $code;

    /**
     * @ORM\ReferenceMany(targetDocument="ForeignName", mappedBy="language")
     **/
    protected $foreignNames;

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
     * Set code
     *
     * @param string $code
     * @return Language
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    public function __construct()
    {
        $this->foreignNames = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add foreignName
     *
     * @param AppBundle\Document\ForeignName $foreignName
     */
    public function addForeignName(\AppBundle\Document\ForeignName $foreignName)
    {
        $this->foreignNames[] = $foreignName;
    }

    /**
     * Remove foreignName
     *
     * @param AppBundle\Document\ForeignName $foreignName
     */
    public function removeForeignName(\AppBundle\Document\ForeignName $foreignName)
    {
        $this->foreignNames->removeElement($foreignName);
    }

    /**
     * Get foreignNames
     *
     * @return \Doctrine\Common\Collections\Collection $foreignNames
     */
    public function getForeignNames()
    {
        return $this->foreignNames;
    }
}
