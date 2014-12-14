<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class DecimalType extends AbstractType
{
    /**
     * @return string
     */
    public function getPhpDocType()
    {
        return 'float';
    }

    /**
     * @return string
     */
    public function getOrmType()
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
