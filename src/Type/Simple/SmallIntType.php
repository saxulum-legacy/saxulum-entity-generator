<?php

namespace Saxulum\EntityGenerator\Type\Simple;

use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;

class SmallIntType extends AbstractType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'int';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'smallint';
    }
}
