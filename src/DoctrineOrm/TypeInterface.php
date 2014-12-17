<?php

namespace Saxulum\ModelGenerator\DoctrineOrm;

use PhpParser\Node;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

interface TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getPropertyNodes(FieldMappingInterface $fieldMapping);

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getConstructNodes(FieldMappingInterface $fieldMapping);

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping);

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping);

    /**
     * @return string
     */
    public function getName();
}
