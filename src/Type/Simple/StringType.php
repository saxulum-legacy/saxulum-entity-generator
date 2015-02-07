<?php

namespace Saxulum\EntityGenerator\Type\Simple;

use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;

class StringType extends AbstractType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'string';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'string';
    }
}
