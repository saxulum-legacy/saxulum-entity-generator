<?php

namespace Saxulum\ModelGenerator\Mapping;

class ModelMapping
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $interfaces;

    /**
     * @var FieldMapping[]
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
     * @param string $interface
     * @return $this
     */
    public function addInterface($interface)
    {
        if(!is_string($interface)) {
            throw new \InvalidArgumentException("Interface name has to be a string!");
        }

        $this->interfaces[$interface] = $interface;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getInterfaces()
    {
        return $this->interfaces;
    }

    /**
     * @param FieldMapping $fieldMapping
     * @return $this
     */
    public function addField(FieldMapping $fieldMapping)
    {
        $this->fieldMappings[$fieldMapping->getName()] = $fieldMapping;

        return $this;
    }

    /**
     * @return FieldMapping[]
     */
    public function getFieldMappings()
    {
        return $this->fieldMappings;
    }
}