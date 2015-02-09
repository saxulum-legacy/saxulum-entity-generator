<?php

namespace Saxulum\EntityGenerator;

use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;

class EntityMapping
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var FieldMappingInterface[]
     */
    protected $fieldMappings;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return $this
     */
    public function addField(FieldMappingInterface $fieldMapping)
    {
        $this->fieldMappings[$fieldMapping->getName()] = $fieldMapping;

        return $this;
    }

    /**
     * @param FieldMappingInterface[] $fieldMappings
     * @return $this
     */
    public function addFields(array $fieldMappings)
    {
        foreach($fieldMappings as $fieldMapping) {
            $this->addField($fieldMapping);
        }

        return $this;
    }

    /**
     * @param FieldMappingInterface[] $fieldMappings
     * @return $this
     */
    public function setFields(array $fieldMappings)
    {
        $this->fieldMappings = array();
        $this->addFields($fieldMappings);

        return $this;
    }

    /**
     * @return FieldMappingInterface[]
     */
    public function getFieldMappings()
    {
        return $this->fieldMappings;
    }
}
