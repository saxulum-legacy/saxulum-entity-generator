<?php

namespace Saxulum\ModelGenerator\Mapping;

use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class ModelMapping
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $baseNamespace;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var FieldMappingInterface[]
     */
    protected $fieldMappings;

    /**
     * @var string
     */
    protected $entityNamespacePart;

    /**
     * @param string $name
     * @param string $baseNamespace
     * @param string $basePath
     * @param string $entityNamespacePart
     */
    public function __construct($name, $baseNamespace, $basePath, $entityNamespacePart = 'Entity')
    {
        $this->name = $name;
        $this->baseNamespace = $baseNamespace;

        if (!is_dir($basePath)) {
            throw new \InvalidArgumentException("There is no directory at path '{$basePath}'");
        }

        $this->basePath = realpath($basePath);
        $this->entityNamespacePart = $entityNamespacePart;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBaseNamespace()
    {
        return $this->baseNamespace;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param FieldMappingInterface $fieldMapping
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

    /**
     * @return string
     */
    public function getEntityNamespacePart()
    {
        return $this->entityNamespacePart;
    }
}
