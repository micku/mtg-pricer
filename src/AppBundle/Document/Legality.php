<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Document(collection="legality")
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

    /**
     * @ORM\ReferenceMany(targetDocument="Card", mappedBy="legalities")
     **/
    protected $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
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

    /**
     * Add card
     *
     * @param AppBundle\Document\Card $card
     */
    public function addCard(\AppBundle\Document\Card $card)
    {
        $this->cards[] = $card;
    }

    /**
     * Remove card
     *
     * @param AppBundle\Document\Card $card
     */
    public function removeCard(\AppBundle\Document\Card $card)
    {
        $this->cards->removeElement($card);
    }

    /**
     * Get cards
     *
     * @return \Doctrine\Common\Collections\Collection $cards
     */
    public function getCards()
    {
        return $this->cards;
    }
}
