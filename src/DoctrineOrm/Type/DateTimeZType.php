<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class DateTimeZType extends AbstractDateType
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
        return 'datetimez';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'datetimez';
    }
}
