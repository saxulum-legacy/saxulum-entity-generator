<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class IntegerType extends AbstractType
{
    /**
     * @return string
     */
    public function getPhpDocType()
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
