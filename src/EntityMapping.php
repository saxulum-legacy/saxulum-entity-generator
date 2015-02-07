<?php

namespace Saxulum\ModelGenerator;

use Saxulum\ModelGenerator\Mapping\FieldMappingInterface;

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
     * @return FieldMappingInterface[]
     */
    public function getFieldMappings()
    {
        return $this->fieldMappings;
    }
}
