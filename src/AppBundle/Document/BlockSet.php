<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Document(collection="block_sets")
 *
 * @ExclusionPolicy("all")
 */
class BlockSet
{
    /**
     * @ORM\Id
     * @Expose
     */
    protected $id;

    public function __construct()
    {
        //$this->cards = new ArrayCollection();
    }

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
     * @ORM\String
     * @Expose
     */
    protected $magicCardsInfoCode;
    /**
     * @ORM\String
     * @Expose
     */
    protected $block;

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
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set magicCardsInfoCode
     *
     * @param string $magicCardsInfoCode
     * @return self
     */
    public function setMagicCardsInfoCode($magicCardsInfoCode)
    {
        $this->magicCardsInfoCode = $magicCardsInfoCode;
        return $this;
    }

    /**
     * Get magicCardsInfoCode
     *
     * @return string $magicCardsInfoCode
     */
    public function getMagicCardsInfoCode()
    {
        return $this->magicCardsInfoCode;
    }

    /**
     * Set block
     *
     * @param string $block
     * @return self
     */
    public function setBlock($block)
    {
        $this->block = $block;
        return $this;
    }

    /**
     * Get block
     *
     * @return string $block
     */
    public function getBlock()
    {
        return $this->block;
    }
}
