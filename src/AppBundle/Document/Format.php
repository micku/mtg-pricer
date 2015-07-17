<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Document(collection="format")
 *
 * @ExclusionPolicy("all")
 */
class Format
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
    protected $isLegal;

    /**
     * @ORM\ReferenceMany(targetDocument="Card", mappedBy="formats")
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
     * Set name
     *
     * @param string $name
     * @return Format
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
     * Set isLegal
     *
     * @param string $isLegal
     * @return Format
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
