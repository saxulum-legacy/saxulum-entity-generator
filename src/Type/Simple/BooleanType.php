<?php

namespace Saxulum\ModelGenerator\Type\Simple;

use Saxulum\ModelGenerator\Mapping\FieldMappingInterface;

class BooleanType extends AbstractType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
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
    public function getName()
    {
        return 'boolean';
    }
}
