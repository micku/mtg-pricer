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
 * @ORM\Table("blockset")
 *
 * @ExclusionPolicy("all")
 */
class BlockSet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Expose
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=5)
     * @Expose
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=5)
     * @Expose
     */
    protected $magicCardsInfoCode;

    /**
     * @ORM\Column(type="string", length=128)
     * @Expose
     */
    protected $block;

    /**
     * ManyToMany(targetEnetity="Card", mappedBy="sets")
     **/
    protected $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }

    public function getCards()
    {
        return $this->cards;
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
     * @return Set
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
     * @return Set
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

    /**
     * Set magicCardsInfoCode
     *
     * @param string $magicCardsInfoCode
     * @return Set
     */
    public function setMagicCardsInfoCode($magicCardsInfoCode)
    {
        $this->magicCardsInfoCode = $magicCardsInfoCode;

        return $this;
    }

    /**
     * Get magicCardsInfoCode
     *
     * @return string 
     */
    public function getMagicCardsInfoCode()
    {
        return $this->magicCardsInfoCode;
    }

    /**
     * Set block
     *
     * @param string $block
     * @return Set
     */
    public function setBlock($block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block
     *
     * @return string 
     */
    public function getBlock()
    {
        return $this->block;
    }
}
