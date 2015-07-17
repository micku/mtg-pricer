<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Entity
 * @ORM\Table("legality")
 *
 * @ExclusionPolicy("all")
 */
class Legality
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
    protected $format;

    /**
     * @ORM\String
     * @Expose
     */
    protected $isLegal;

    /*
     * ManyToMany(targetEnetity="Card", mappedBy="legalities")
    protected $cards;
     **/

    /*
    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }
     */

    /*
    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }

    public function getCards()
    {
        return $this->cards;
    }
     */

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
     * Set format
     *
     * @param string $format
     * @return Legality
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string 
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set isLegal
     *
     * @param string $isLegal
     * @return Legality
     */
    public function setIsLegal($isLegal)
    {
        $this->isLegal = $isLegal;

        return $this;
    }

    /**
     * Get isLegal
     *
     * @return string 
     */
    public function getIsLegal()
    {
        return $this->isLegal;
    }
}
