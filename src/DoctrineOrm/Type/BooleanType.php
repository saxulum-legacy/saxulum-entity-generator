<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class BooleanType extends AbstractType
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'bool';
    }

    /**
     * @return string
     */
    public function getGetterPrefix()
    {
        return 'is';
    }

    /**
     * @return string
     */
    public function getOrmType()
    {
        return 'boolean';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'boolean';
    }
}
