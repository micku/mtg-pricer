<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\EmbeddedDocument
 *
 * @ExclusionPolicy("all")
 */
class ForeignName
{
    /**
     * @ORM\String
     * @Expose
     */
    protected $name;

    /*
     * @ORM\ManyToOne(targetEntity="Card", inversedBy="foreignNames")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id")
     * @Expose
    protected $card;
     **/

    /**
     * @ORM\ReferenceOne(targetDocument="Language", simple=true, inversedBy="foreignNames")
     * @Expose
     **/
    protected $language;

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
     * @return ForeignName
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
     * Set language
     *
     * @param AppBundle\Document\Language $language
     * @return self
     */
    public function setLanguage(\AppBundle\Document\Language $language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Get language
     *
     * @return AppBundle\Document\Language $language
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
