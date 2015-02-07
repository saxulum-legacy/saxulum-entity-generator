<?php

namespace Saxulum\ModelGenerator\Type\Simple;

use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class TextType extends AbstractType
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
        return 'text';
    }
}