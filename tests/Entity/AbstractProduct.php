<?php

namespace Saxulum\Entity\Base;

abstract class AbstractProduct
{
    /**
     * @var array
     */
    protected $array;
    /**
     * @var int
     */
    protected $bigint;
    /**
     * @var string
     */
    protected $blob;
    /**
     * @var bool
     */
    protected $bool;
    /**
     * @var \DateTime
     */
    protected $datetime;
    /**
     * @var \DateTime
     */
    protected $datetimez;
    /**
     * @var \DateTime
     */
    protected $date;
    /**
     * @var string
     */
    protected $decimal;
    /**
     * @var float
     */
    protected $float;
    /**
     * @var string
     */
    protected $guid;
    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $integer;
    /**
     * @var array
     */
    protected $jsonArray;
    /**
     * @var \stdClass
     */
    protected $object;
    /**
     * @var array
     */
    protected $simpleArray;
    /**
     * @var int
     */
    protected $smallint;
    /**
     * @var string
     */
    protected $string;
    /**
     * @var string
     */
    protected $text;
    /**
     * @var \DateTime
     */
    protected $time;
    /**
     * @var \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    protected $unidirectionalMany2Manies;
    /**
     * @var \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    protected $owningBidirectionalMany2Manies;
    /**
     * @var \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    protected $inverseBidirectionalMany2Manies;
    /**
     * @var \Saxulum\Entity\Product
     */
    protected $unidirectionalMany2One;
    /**
     * @var \Saxulum\Entity\Product
     */
    protected $one;
    /**
     * @var \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    protected $manies;
    /**
     * @var \Saxulum\Entity\Product
     */
    protected $unidirectionalOne2One;
    /**
     * @var \Saxulum\Entity\Product
     */
    protected $owningBidirectionalOne2One;
    /**
     * @var \Saxulum\Entity\Product
     */
    protected $inverseBidirectionalOne2One;
    public function __construct()
    {
        $this->unidirectionalMany2Manies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->owningBidirectionalMany2Manies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inverseBidirectionalMany2Manies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->manies = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @param array $array
     * @return $this
     */
    public function setArray(array $array)
    {
        $this->array = $array;
        return $this;
    }
    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }
    /**
     * @param int $bigint
     * @return $this
     */
    public function setBigint($bigint)
    {
        $this->bigint = $bigint;
        return $this;
    }
    /**
     * @return int
     */
    public function getBigint()
    {
        return $this->bigint;
    }
    /**
     * @param string $blob
     * @return $this
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }
    /**
     * @return string
     */
    public function getBlob()
    {
        return $this->blob;
    }
    /**
     * @param bool $bool
     * @return $this
     */
    public function setBool($bool)
    {
        $this->bool = $bool;
        return $this;
    }
    /**
     * @return bool
     */
    public function isBool()
    {
        return $this->bool;
    }
    /**
     * @param \DateTime $datetime
     * @return $this
     */
    public function setDatetime(\DateTime $datetime = null)
    {
        $this->datetime = $datetime;
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
    /**
     * @param \DateTime $datetimez
     * @return $this
     */
    public function setDatetimez(\DateTime $datetimez = null)
    {
        $this->datetimez = $datetimez;
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getDatetimez()
    {
        return $this->datetimez;
    }
    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date = null)
    {
        $this->date = $date;
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @param string $decimal
     * @return $this
     */
    public function setDecimal($decimal)
    {
        $this->decimal = $decimal;
        return $this;
    }
    /**
     * @return string
     */
    public function getDecimal()
    {
        return $this->decimal;
    }
    /**
     * @param float $float
     * @return $this
     */
    public function setFloat($float)
    {
        $this->float = $float;
        return $this;
    }
    /**
     * @return float
     */
    public function getFloat()
    {
        return $this->float;
    }
    /**
     * @param string $guid
     * @return $this
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
        return $this;
    }
    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param int $integer
     * @return $this
     */
    public function setInteger($integer)
    {
        $this->integer = $integer;
        return $this;
    }
    /**
     * @return int
     */
    public function getInteger()
    {
        return $this->integer;
    }
    /**
     * @param array $jsonArray
     * @return $this
     */
    public function setJsonArray(array $jsonArray)
    {
        $this->jsonArray = $jsonArray;
        return $this;
    }
    /**
     * @return array
     */
    public function getJsonArray()
    {
        return $this->jsonArray;
    }
    /**
     * @param \stdClass $object
     * @return $this
     */
    public function setObject(\stdClass $object = null)
    {
        $this->object = $object;
        return $this;
    }
    /**
     * @return \stdClass
     */
    public function getObject()
    {
        return $this->object;
    }
    /**
     * @param array $simpleArray
     * @return $this
     */
    public function setSimpleArray(array $simpleArray)
    {
        $this->simpleArray = $simpleArray;
        return $this;
    }
    /**
     * @return array
     */
    public function getSimpleArray()
    {
        return $this->simpleArray;
    }
    /**
     * @param int $smallint
     * @return $this
     */
    public function setSmallint($smallint)
    {
        $this->smallint = $smallint;
        return $this;
    }
    /**
     * @return int
     */
    public function getSmallint()
    {
        return $this->smallint;
    }
    /**
     * @param string $string
     * @return $this
     */
    public function setString($string)
    {
        $this->string = $string;
        return $this;
    }
    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }
    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * @param \DateTime $time
     * @return $this
     */
    public function setTime(\DateTime $time = null)
    {
        $this->time = $time;
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }
    /**
     * @param \Saxulum\Entity\Product $unidirectionalMany2Many
     * @return $this
     */
    public function addUnidirectionalMany2Many(\Saxulum\Entity\Product $unidirectionalMany2Many)
    {
        $this->unidirectionalMany2Manies->add($unidirectionalMany2Many);
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product $unidirectionalMany2Many
     * @return $this
     */
    public function removeUnidirectionalMany2Many(\Saxulum\Entity\Product $unidirectionalMany2Many)
    {
        $this->unidirectionalMany2Manies->removeElement($unidirectionalMany2Many);
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection $unidirectionalMany2Manies
     * @return $this
     */
    public function setUnidirectionalMany2Manies($unidirectionalMany2Manies)
    {
        $this->unidirectionalMany2Manies = $unidirectionalMany2Manies;
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    public function getUnidirectionalMany2Manies()
    {
        return $this->unidirectionalMany2Manies;
    }
    /**
     * @param \Saxulum\Entity\Product $owningBidirectionalMany2Many
     * @param bool $stopPropagation
     * @return $this
     */
    public function addOwningBidirectionalMany2Many(\Saxulum\Entity\Product $owningBidirectionalMany2Many, $stopPropagation = false)
    {
        $this->owningBidirectionalMany2Manies->add($owningBidirectionalMany2Many);
        if (!$stopPropagation) {
            $owningBidirectionalMany2Many->addInverseBidirectionalMany2Many($this, true);
        }
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product $owningBidirectionalMany2Many
     * @param bool $stopPropagation
     * @return $this
     */
    public function removeOwningBidirectionalMany2Many(\Saxulum\Entity\Product $owningBidirectionalMany2Many, $stopPropagation = false)
    {
        $this->owningBidirectionalMany2Manies->removeElement($owningBidirectionalMany2Many);
        if (!$stopPropagation) {
            $owningBidirectionalMany2Many->removeInverseBidirectionalMany2Many($this, true);
        }
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection $owningBidirectionalMany2Manies
     * @return $this
     */
    public function setOwningBidirectionalMany2Manies($owningBidirectionalMany2Manies)
    {
        foreach ($this->owningBidirectionalMany2Manies as $owningBidirectionalMany2Many) {
            $this->removeOwningBidirectionalMany2Many($owningBidirectionalMany2Many);
        }
        foreach ($owningBidirectionalMany2Manies as $owningBidirectionalMany2Many) {
            $this->addOwningBidirectionalMany2Many($owningBidirectionalMany2Many);
        }
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    public function getOwningBidirectionalMany2Manies()
    {
        return $this->owningBidirectionalMany2Manies;
    }
    /**
     * @param \Saxulum\Entity\Product $inverseBidirectionalMany2Many
     * @param bool $stopPropagation
     * @return $this
     */
    public function addInverseBidirectionalMany2Many(\Saxulum\Entity\Product $inverseBidirectionalMany2Many, $stopPropagation = false)
    {
        $this->inverseBidirectionalMany2Manies->add($inverseBidirectionalMany2Many);
        if (!$stopPropagation) {
            $inverseBidirectionalMany2Many->addOwningBidirectionalMany2Many($this, true);
        }
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product $inverseBidirectionalMany2Many
     * @param bool $stopPropagation
     * @return $this
     */
    public function removeInverseBidirectionalMany2Many(\Saxulum\Entity\Product $inverseBidirectionalMany2Many, $stopPropagation = false)
    {
        $this->inverseBidirectionalMany2Manies->removeElement($inverseBidirectionalMany2Many);
        if (!$stopPropagation) {
            $inverseBidirectionalMany2Many->removeOwningBidirectionalMany2Many($this, true);
        }
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection $inverseBidirectionalMany2Manies
     * @return $this
     */
    public function setInverseBidirectionalMany2Manies($inverseBidirectionalMany2Manies)
    {
        foreach ($this->inverseBidirectionalMany2Manies as $inverseBidirectionalMany2Many) {
            $this->removeInverseBidirectionalMany2Many($inverseBidirectionalMany2Many);
        }
        foreach ($inverseBidirectionalMany2Manies as $inverseBidirectionalMany2Many) {
            $this->addInverseBidirectionalMany2Many($inverseBidirectionalMany2Many);
        }
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    public function getInverseBidirectionalMany2Manies()
    {
        return $this->inverseBidirectionalMany2Manies;
    }
    /**
     * @param \Saxulum\Entity\Product $unidirectionalMany2One
     * @return $this
     */
    public function setUnidirectionalMany2One(\Saxulum\Entity\Product $unidirectionalMany2One = null)
    {
        $this->unidirectionalMany2One = $unidirectionalMany2One;
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product
     */
    public function getUnidirectionalMany2One()
    {
        return $this->unidirectionalMany2One;
    }
    /**
     * @param \Saxulum\Entity\Product $one
     * @param bool $stopPropagation
     * @return $this
     */
    public function setOne(\Saxulum\Entity\Product $one = null, $stopPropagation = false)
    {
        if (!$stopPropagation) {
            if (null !== $this->one) {
                $this->one->removeMany($this, true);
            }
            if (null !== $one) {
                $one->addMany($this, true);
            }
        }
        $this->one = $one;
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product
     */
    public function getOne()
    {
        return $this->one;
    }
    /**
     * @param \Saxulum\Entity\Product $many
     * @param bool $stopPropagation
     * @return $this
     */
    public function addMany(\Saxulum\Entity\Product $many, $stopPropagation = false)
    {
        $this->manies->add($many);
        if (!$stopPropagation) {
            $many->setOne($this, true);
        }
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product $many
     * @param bool $stopPropagation
     * @return $this
     */
    public function removeMany(\Saxulum\Entity\Product $many, $stopPropagation = false)
    {
        $this->manies->removeElement($many);
        if (!$stopPropagation) {
            $many->setOne(null, true);
        }
        return $this;
    }
    /**
     * @param \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection $manies
     * @return $this
     */
    public function setManies($manies)
    {
        foreach ($this->manies as $many) {
            $this->removeMany($many);
        }
        foreach ($manies as $many) {
            $this->addMany($many);
        }
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product[]|\Doctrine\Common\Collections\Collection
     */
    public function getManies()
    {
        return $this->manies;
    }
    /**
     * @param \Saxulum\Entity\Product $unidirectionalOne2One
     * @return $this
     */
    public function setUnidirectionalOne2One(\Saxulum\Entity\Product $unidirectionalOne2One = null)
    {
        $this->unidirectionalOne2One = $unidirectionalOne2One;
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product
     */
    public function getUnidirectionalOne2One()
    {
        return $this->unidirectionalOne2One;
    }
    /**
     * @param \Saxulum\Entity\Product $owningBidirectionalOne2One
     * @param bool $stopPropagation
     * @return $this
     */
    public function setOwningBidirectionalOne2One(\Saxulum\Entity\Product $owningBidirectionalOne2One = null, $stopPropagation = false)
    {
        if (!$stopPropagation) {
            if (null !== $this->owningBidirectionalOne2One) {
                $this->owningBidirectionalOne2One->setInverseBidirectionalOne2One($this, true);
            }
            if (null !== $owningBidirectionalOne2One) {
                $owningBidirectionalOne2One->setInverseBidirectionalOne2One($this, true);
            }
        }
        $this->owningBidirectionalOne2One = $owningBidirectionalOne2One;
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product
     */
    public function getOwningBidirectionalOne2One()
    {
        return $this->owningBidirectionalOne2One;
    }
    /**
     * @param \Saxulum\Entity\Product $inverseBidirectionalOne2One
     * @param bool $stopPropagation
     * @return $this
     */
    public function setInverseBidirectionalOne2One(\Saxulum\Entity\Product $inverseBidirectionalOne2One = null, $stopPropagation = false)
    {
        if (!$stopPropagation) {
            if (null !== $this->inverseBidirectionalOne2One) {
                $this->inverseBidirectionalOne2One->setOwningBidirectionalOne2One($this, true);
            }
            if (null !== $inverseBidirectionalOne2One) {
                $inverseBidirectionalOne2One->setOwningBidirectionalOne2One($this, true);
            }
        }
        $this->inverseBidirectionalOne2One = $inverseBidirectionalOne2One;
        return $this;
    }
    /**
     * @return \Saxulum\Entity\Product
     */
    public function getInverseBidirectionalOne2One()
    {
        return $this->inverseBidirectionalOne2One;
    }
    /**
     * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata
     */
    public static function loadMetadata(\Doctrine\ORM\Mapping\ClassMetadata $metadata)
    {
        $builder = new \Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder($metadata);
        $builder->setMappedSuperClass();
        $builder->addField('array', 'array');
        $builder->addField('bigint', 'bigint');
        $builder->addField('blob', 'blob');
        $builder->addField('bool', 'boolean');
        $builder->addField('datetime', 'datetime');
        $builder->addField('datetimez', 'datetimez');
        $builder->addField('date', 'date');
        $builder->addField('decimal', 'decimal');
        $builder->addField('float', 'float');
        $builder->addField('guid', 'guid');
        $builder->createField('id', 'integer')->isPrimaryKey()->generatedValue()->build();
        $builder->addField('integer', 'integer');
        $builder->addField('jsonArray', 'json_array');
        $builder->addField('object', 'object');
        $builder->addField('simpleArray', 'simple_array');
        $builder->addField('smallint', 'smallint');
        $builder->addField('string', 'string');
        $builder->addField('text', 'text');
        $builder->addField('time', 'time');
        $builder->addOwningManyToMany('unidirectionalMany2Manies', '\\Saxulum\\Entity\\Product');
        $builder->addOwningManyToMany('owningBidirectionalMany2Manies', '\\Saxulum\\Entity\\Product', 'inverseBidirectionalMany2Manies');
        $builder->addInverseManyToMany('inverseBidirectionalMany2Manies', '\\Saxulum\\Entity\\Product', 'owningBidirectionalMany2Manies');
        $builder->addManyToOne('unidirectionalMany2One', '\\Saxulum\\Entity\\Product');
        $builder->addManyToOne('one', '\\Saxulum\\Entity\\Product', 'manies');
        $builder->addOneToMany('manies', '\\Saxulum\\Entity\\Product', 'one');
        $builder->addOwningOneToOne('unidirectionalOne2One', '\\Saxulum\\Entity\\Product');
        $builder->addOwningOneToOne('owningBidirectionalOne2One', '\\Saxulum\\Entity\\Product', 'inverseBidirectionalOne2One');
        $builder->addInverseOneToOne('inverseBidirectionalOne2One', '\\Saxulum\\Entity\\Product', 'owningBidirectionalOne2One');
    }
}