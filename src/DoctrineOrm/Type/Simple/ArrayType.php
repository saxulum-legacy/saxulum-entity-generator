<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Simple;

use PhpParser\Node\Name;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class ArrayType extends AbstractType
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return null|string|Name
     */
    protected function getSetterType(FieldMappingInterface $fieldMapping)
    {
        return 'array';
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'array';
    }

    /**
     * @return string
     */
    public function getOrmType()
    {
        return 'json_array';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'array';
    }
}
