<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class IntegerType extends AbstractType
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'int';
    }

    /**
     * @return string
     */
    public function getOrmType()
    {
        return 'integer';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'integer';
    }
}
