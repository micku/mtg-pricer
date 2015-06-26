<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

#use AppBundle\Entity\Rarity;

/**
 * @ORM\Entity
 * @ORM\Table("card")
 *
 * @ExclusionPolicy("all")
 **/
class Card
{
    const NUM_ITEMS = 20;

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
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $manaCost;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Expose
     */
    protected $cmc;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Expose
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Expose
     */
    protected $flavor;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $artist;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $number;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $power;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Expose
     */
    protected $toughness;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Expose
     */
    protected $layout;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Expose
     */
    protected $multiverseId;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $imageName;

    /**
     * @ORM\ManyToOne(targetEntity="Rarity")
     * @ORM\JoinColumn(name="rarity_id", referencedColumnName="id", nullable=true)
     **/
    protected $rarity;

    /**
     * @ORM\OneToMany(targetEntity="ForeignName", mappedBy="card")
     **/
    protected $foreignNames;

    /**
     * @ORM\ManyToMany(targetEntity="Color", inversedBy="cards")
     * @ORM\JoinTable(name="cards_colors")
     **/
    protected $colors;

    /**
     * @ORM\ManyToMany(targetEntity="SuperType", inversedBy="cards")
     * @ORM\JoinTable(name="cards_superType")
     **/
    protected $superTypes;

    /**
     * @ORM\ManyToMany(targetEntity="Type", inversedBy="cards")
     * @ORM\JoinTable(name="cards_type")
     **/
    protected $types;

    /**
     * @ORM\ManyToMany(targetEntity="SubType", inversedBy="cards")
     * @ORM\JoinTable(name="cards_subType")
     **/
    protected $subTypes;

    /**
     * @ORM\ManyToMany(targetEntity="Legality", inversedBy="cards")
     * @ORM\JoinTable(name="cards_legality")
     **/
    protected $legalities;

    /**
     * @ORM\ManyToMany(targetEntity="Ruling", inversedBy="cards")
     * @ORM\JoinTable(name="cards_ruling")
     **/
    protected $rulings;

    /**
     * @ORM\ManyToMany(targetEntity="BlockSet", inversedBy="cards")
     * @ORM\JoinTable(name="cards_set")
     **/
    protected $sets;

    public function __construct()
    {
        //$this->rarity = new ArrayCollection();
        $this->foreignNames = new ArrayCollection();

        $this->colors = new ArrayCollection();
        $this->superTypes = new ArrayCollection();
        $this->types = new ArrayCollection();
        $this->subTypes = new ArrayCollection();
        $this->legalities = new ArrayCollection();
        $this->rulings = new ArrayCollection();
        $this->sets = new ArrayCollection();
    }

    public function addForeignNames(ForeignName $foreignName)
    {
        $foreignName->setCard($this);
        $this->foreignNames[] = $foreignName;
    }

    public function getForeignNames()
    {
        return $this->foreignNames;
    }

    public function setRarity($rarity)
    {
        $rarity->addCard($this);
        $this->rarity = $rarity;
    }

    public function getRarity()
    {
        return $this->rarity;
    }

    public function addColor(Color $color)
    {
        $color->addCard($this);
        $this->colors[] = $color;
    }

    public function getColors()
    {
        return $this->colors;
    }

    public function addSuperType(SuperType $superType)
    {
        $superType->addCard($this);
        $this->superTypes[] = $superType;
    }

    public function getSuperTypes()
    {
        return $this->superTypes;
    }

    public function addType(Type $type)
    {
        $type->addCard($this);
        $this->types[] = $type;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function addSubType(SubType $subType)
    {
        $subType->addCard($this);
        $this->subTypes[] = $subType;
    }

    public function getSubTypes()
    {
        return $this->subTypes;
    }

    public function addLegality(Legality $legality)
    {
        $legality->addCard($this);
        $this->legalities[] = $legality;
    }

    public function getLegalities()
    {
        return $this->legalities;
    }

    public function addRuling(Ruling $ruling)
    {
        $ruling->addCard($this);
        $this->rulings[] = $ruling;
    }

    public function getRulings()
    {
        return $this->rulings;
    }

    public function addSet(BlockSet $set)
    {
        $set->addCard($this);
        $this->sets[] = $set;
    }

    public function getSets()
    {
        return $this->sets;
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
     * @param \AppBundle\Entity\ForeignName $foreignNames
     * @return Card
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
     * Remove colors
     *
     * @param \AppBundle\Entity\Color $colors
     */
    public function removeColor(\AppBundle\Entity\Color $colors)
    {
        $this->colors->removeElement($colors);
    }

    /**
     * Remove superTypes
     *
     * @param \AppBundle\Entity\SuperType $superTypes
     */
    public function removeSuperType(\AppBundle\Entity\SuperType $superTypes)
    {
        $this->superTypes->removeElement($superTypes);
    }

    /**
     * Remove types
     *
     * @param \AppBundle\Entity\Type $types
     */
    public function removeType(\AppBundle\Entity\Type $types)
    {
        $this->types->removeElement($types);
    }

    /**
     * Remove subTypes
     *
     * @param \AppBundle\Entity\SubType $subTypes
     */
    public function removeSubType(\AppBundle\Entity\SubType $subTypes)
    {
        $this->subTypes->removeElement($subTypes);
    }

    /**
     * Remove legalities
     *
     * @param \AppBundle\Entity\Legality $legalities
     */
    public function removeLegality(\AppBundle\Entity\Legality $legalities)
    {
        $this->legalities->removeElement($legalities);
    }

    /**
     * Remove rulings
     *
     * @param \AppBundle\Entity\Ruling $rulings
     */
    public function removeRuling(\AppBundle\Entity\Ruling $rulings)
    {
        $this->rulings->removeElement($rulings);
    }

    /**
     * Remove sets
     *
     * @param \AppBundle\Entity\Set $sets
     */
    public function removeSet(\AppBundle\Entity\Set $sets)
    {
        $this->sets->removeElement($sets);
    }
}
