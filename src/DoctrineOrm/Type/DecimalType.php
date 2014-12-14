<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class DecimalType extends AbstractSimpleType
{
    /**
     * @return string
     */
    public function getDoctrineOrmPhpDocType()
    {
        return 'float';
    }

    /**
     * @return string
     */
    public function getDoctrineOrmType()
    {
        return 'decimal';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decimal';
    }
}
