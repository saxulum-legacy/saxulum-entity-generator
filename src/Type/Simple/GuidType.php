<?php

namespace Saxulum\ModelGenerator\Type\Simple;

use Saxulum\ModelGenerator\Mapping\FieldMappingInterface;

class GuidType extends AbstractType
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
        return 'guid';
    }
}
