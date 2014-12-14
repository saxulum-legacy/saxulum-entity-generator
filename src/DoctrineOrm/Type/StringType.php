<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class StringType extends AbstractType
{
    /**
     * @return string
     */
    public function getPhpDocType()
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
