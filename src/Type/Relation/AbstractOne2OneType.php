<?php

namespace Saxulum\EntityGenerator\Type\Relation;

use PhpParser\Node;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Relation\AbstractRelationMapping;

abstract class AbstractOne2OneType extends Abstract2OneRelationType
{
    /**
     * @param  AbstractRelationMapping $fieldMapping
     * @return string
     */
    protected function getVarString(AbstractRelationMapping $fieldMapping)
    {
        return $fieldMapping->getTargetModel();
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getConstructNodes(FieldMappingInterface $fieldMapping)
    {
        return array();
    }
}
