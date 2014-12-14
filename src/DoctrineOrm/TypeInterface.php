<?php

namespace Saxulum\ModelGenerator\DoctrineOrm;

use PhpParser\Node;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

interface TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getPropertyNode(FieldMappingInterface $fieldMapping);

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node|null
     */
    public function getConstructNode(FieldMappingInterface $fieldMapping);

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping);

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getMetadataNode(FieldMappingInterface $fieldMapping);

    /**
     * @return string
     */
    public function getName();
}
