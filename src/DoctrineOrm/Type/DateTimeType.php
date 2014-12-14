<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class DateTimeType extends AbstractDateType
{
    /**
     * @return string
     */
    public function getDoctrineOrmPhpDocType()
    {
        return '\DateTime';
    }

    /**
     * @return string
     */
    public function getDoctrineOrmType()
    {
        return 'datetime';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'datetime';
    }
}
