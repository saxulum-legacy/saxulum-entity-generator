<?php

namespace Saxulum\EntityGenerator\Type\Simple;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Simple\ObjectFieldMapping;

class ObjectType extends AbstractType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return null|Expr
     */
    protected function getSetterDefault(FieldMappingInterface $fieldMapping)
    {
        return new ConstFetch(new Name('null'));
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return null|string|Name
     */
    protected function getSetterType(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof ObjectFieldMapping) {
            throw new \InvalidArgumentException('Field mapping has to be ObjectFieldMapping!');
        }

        return new Name($fieldMapping->getClass());
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof ObjectFieldMapping) {
            throw new \InvalidArgumentException('Field mapping has to be ObjectFieldMapping!');
        }

        return $fieldMapping->getClass();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'object';
    }
}
