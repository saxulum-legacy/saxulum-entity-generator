<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class TimeType extends AbstractDateType
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
        return 'time';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'time';
    }
}
