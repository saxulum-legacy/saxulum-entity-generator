<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Simple;

use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class StringType extends AbstractType
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'string';
    }

    /**
     * @return string
     */
    public function getOrmType()
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
