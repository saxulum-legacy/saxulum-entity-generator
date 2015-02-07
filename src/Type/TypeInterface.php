<?php

namespace Saxulum\EntityGenerator\Type;

use PhpParser\Node;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;

interface TypeInterface
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getPropertyNodes(FieldMappingInterface $fieldMapping);

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getConstructNodes(FieldMappingInterface $fieldMapping);

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping);

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping);

    /**
     * @return string
     */
    public function getName();
}
