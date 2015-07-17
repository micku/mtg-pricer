<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Document(collection="colors")
 *
 * @ExclusionPolicy("all")
 */
class Color
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
     * @ORM\ReferenceMany(targetDocument="Card", mappedBy="colors")
     */
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
     * @return Color
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
