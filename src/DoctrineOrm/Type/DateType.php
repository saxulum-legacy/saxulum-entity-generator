<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class DateType extends AbstractDateType
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
        return 'date';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'date';
    }
}
