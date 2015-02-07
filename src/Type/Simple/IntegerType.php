<?php

namespace Saxulum\ModelGenerator\Type\Simple;

use Saxulum\ModelGenerator\Mapping\FieldMappingInterface;

class IntegerType extends AbstractType
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
        return 'integer';
    }
}
