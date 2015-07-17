<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Document(collection="cards")
 *
 * @ExclusionPolicy("all")
 **/
class Card
{
    const NUM_ITEMS = 20;

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
    protected $manaCost;

    /**
     * @ORM\Float
     * @Expose
     */
    protected $cmc;

    /**
     * @ORM\String
     * @Expose
     */
    protected $type;

    /**
     * @ORM\String
     * @Expose
     */
    protected $text;

    /**
     * @ORM\String
     * @Expose
     */
    protected $flavor;

    /**
     * @ORM\String
     * @Expose
     */
    protected $artist;

    /**
     * @ORM\String
     * @Expose
     */
    protected $number;

    /**
     * @ORM\String
     * @Expose
     */
    protected $power;

    /**
     * @ORM\String
     * @Expose
     */
    protected $toughness;

    /**
     * @ORM\String
     * @Expose
     */
    protected $layout;

    /**
     * @ORM\Int
     * @Expose
     */
    protected $multiverseId;

    /**
     * @ORM\String
     * @Expose
     */
    protected $imageName;

    /**
     * @ORM\ReferenceOne(targetDocument="Rarity", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $rarity;

    /**
     * @ORM\EmbedMany(targetDocument="ForeignName")
     * @Expose
     **/
    protected $foreignNames = array();

    /**
     * @ORM\ReferenceMany(targetDocument="Color", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $colors;

    /**
     * @ORM\ReferenceMany(targetDocument="SuperType", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $superTypes;

    /**
     * @ORM\ReferenceMany(targetDocument="Type", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $types;

    /**
     * @ORM\ReferenceMany(targetDocument="SubType", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $subTypes;

    /**
     * @ORM\ReferenceMany(targetDocument="Legality", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $legalities;

    /**
     * @ORM\ReferenceMany(targetDocument="Ruling", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $rulings;

    /**
     * @ORM\ReferenceMany(targetDocument="BlockSet", simple=true, inversedBy="cards")
     * @Expose
     **/
    protected $sets;

    public function __construct()
    {
        //$this->rarity = new ArrayCollection();
        /*
        $this->foreignNames = new ArrayCollection();
         */

        $this->colors = new ArrayCollection();
        $this->superTypes = new ArrayCollection();
        $this->types = new ArrayCollection();
        $this->subTypes = new ArrayCollection();
        $this->legalities = new ArrayCollection();
        $this->rulings = new ArrayCollection();
        $this->sets = new ArrayCollection();
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
     * @return Card
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
     * Set manaCost
     *
     * @param string $manaCost
     * @return Card
     */
    public function setManaCost($manaCost)
    {
        $this->manaCost = $manaCost;

        return $this;
    }

    /**
     * Get manaCost
     *
     * @return string 
     */
    public function getManaCost()
    {
        return $this->manaCost;
    }

    /**
     * Set cmc
     *
     * @param string $cmc
     * @return Card
     */
    public function setCmc($cmc)
    {
        $this->cmc = $cmc;

        return $this;
    }

    /**
     * Get cmc
     *
     * @return string 
     */
    public function getCmc()
    {
        return $this->cmc;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Card
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Card
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set flavor
     *
     * @param string $flavor
     * @return Card
     */
    public function setFlavor($flavor)
    {
        $this->flavor = $flavor;

        return $this;
    }

    /**
     * Get flavor
     *
     * @return string 
     */
    public function getFlavor()
    {
        return $this->flavor;
    }

    /**
     * Set artist
     *
     * @param string $artist
     * @return Card
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return string 
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Card
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set power
     *
     * @param string $power
     * @return Card
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return string 
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set toughness
     *
     * @param string $toughness
     * @return Card
     */
    public function setToughness($toughness)
    {
        $this->toughness = $toughness;

        return $this;
    }

    /**
     * Get toughness
     *
     * @return string 
     */
    public function getToughness()
    {
        return $this->toughness;
    }

    /**
     * Set layout
     *
     * @param string $layout
     * @return Card
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get layout
     *
     * @return string 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set multiverseId
     *
     * @param integer $multiverseId
     * @return Card
     */
    public function setMultiverseId($multiverseId)
    {
        $this->multiverseId = $multiverseId;

        return $this;
    }

    /**
     * Get multiverseId
     *
     * @return integer 
     */
    public function getMultiverseId()
    {
        return $this->multiverseId;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Card
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Add foreignNames
     *
     * @param \AppBundle\Document\ForeignName $foreignNames
     * @return Card
     */
    public function addForeignName(\AppBundle\Document\ForeignName $foreignNames)
    {
        $this->foreignNames[] = $foreignNames;

        return $this;
    }

    /**
     * Remove foreignNames
     *
     * @param \AppBundle\Document\ForeignName $foreignNames
     */
    public function removeForeignName(\AppBundle\Document\ForeignName $foreignNames)
    {
        $this->foreignNames->removeElement($foreignNames);
    }

    /**
     * Remove colors
     *
     * @param \AppBundle\Document\Color $colors
     */
    public function removeColor(\AppBundle\Document\Color $colors)
    {
        $this->colors->removeElement($colors);
    }

    /**
     * Remove superTypes
     *
     * @param \AppBundle\Document\SuperType $superTypes
     */
    public function removeSuperType(\AppBundle\Document\SuperType $superTypes)
    {
        $this->superTypes->removeElement($superTypes);
    }

    /**
     * Remove types
     *
     * @param \AppBundle\Document\Type $types
     */
    public function removeType(\AppBundle\Document\Type $types)
    {
        $this->types->removeElement($types);
    }

    /**
     * Remove subTypes
     *
     * @param \AppBundle\Document\SubType $subTypes
     */
    public function removeSubType(\AppBundle\Document\SubType $subTypes)
    {
        $this->subTypes->removeElement($subTypes);
    }

    /**
     * Remove legalities
     *
     * @param \AppBundle\Document\Legality $legalities
     */
    public function removeLegality(\AppBundle\Document\Legality $legalities)
    {
        $this->legalities->removeElement($legalities);
    }

    /**
     * Remove rulings
     *
     * @param \AppBundle\Document\Ruling $rulings
     */
    public function removeRuling(\AppBundle\Document\Ruling $rulings)
    {
        $this->rulings->removeElement($rulings);
    }

    /**
     * Remove sets
     *
     * @param \AppBundle\Document\Set $sets
     */
    public function removeSet(\AppBundle\Document\BlockSet $sets)
    {
        $this->sets->removeElement($sets);
    }

    /**
     * Add set
     *
     * @param AppBundle\Document\BlockSet $set
     */
    public function addSet(\AppBundle\Document\BlockSet $set)
    {
        $this->sets[] = $set;
    }

    /**
     * Get sets
     *
     * @return \Doctrine\Common\Collections\Collection $sets
     */
    public function getSets()
    {
        return $this->sets;
    }

    /**
     * Add color
     *
     * @param AppBundle\Document\Color $color
     */
    public function addColor(\AppBundle\Document\Color $color)
    {
        $this->colors[] = $color;
    }

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection $colors
     */
    public function getColors()
    {
        return $this->colors;
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

    /**
     * Set rarity
     *
     * @param AppBundle\Document\Rarity $rarity
     * @return self
     */
    public function setRarity(\AppBundle\Document\Rarity $rarity)
    {
        $this->rarity = $rarity;
        return $this;
    }

    /**
     * Get rarity
     *
     * @return AppBundle\Document\Rarity $rarity
     */
    public function getRarity()
    {
        return $this->rarity;
    }

    /**
     * Add superType
     *
     * @param AppBundle\Document\SuperType $superType
     */
    public function addSuperType(\AppBundle\Document\SuperType $superType)
    {
        $this->superTypes[] = $superType;
    }

    /**
     * Get superTypes
     *
     * @return \Doctrine\Common\Collections\Collection $superTypes
     */
    public function getSuperTypes()
    {
        return $this->superTypes;
    }

    /**
     * Add type
     *
     * @param AppBundle\Document\Type $type
     */
    public function addType(\AppBundle\Document\Type $type)
    {
        $this->types[] = $type;
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection $types
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Add subType
     *
     * @param AppBundle\Document\SubType $subType
     */
    public function addSubType(\AppBundle\Document\SubType $subType)
    {
        $this->subTypes[] = $subType;
    }

    /**
     * Get subTypes
     *
     * @return \Doctrine\Common\Collections\Collection $subTypes
     */
    public function getSubTypes()
    {
        return $this->subTypes;
    }

    /**
     * Add legality
     *
     * @param AppBundle\Document\Legality $legality
     */
    public function addLegality(\AppBundle\Document\Legality $legality)
    {
        $this->legalities[] = $legality;
    }

    /**
     * Get legalities
     *
     * @return \Doctrine\Common\Collections\Collection $legalities
     */
    public function getLegalities()
    {
        return $this->legalities;
    }

    /**
     * Add ruling
     *
     * @param AppBundle\Document\Ruling $ruling
     */
    public function addRuling(\AppBundle\Document\Ruling $ruling)
    {
        $this->rulings[] = $ruling;
    }

    /**
     * Get rulings
     *
     * @return \Doctrine\Common\Collections\Collection $rulings
     */
    public function getRulings()
    {
        return $this->rulings;
    }
}
