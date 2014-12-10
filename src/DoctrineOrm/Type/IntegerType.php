<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class IntegerType extends AbstractSimpleType
{
    /**
     * @return string
     */
    public function getDoctrineOrmPhpDocType()
    {
        return 'int';
    }

    /**
     * @return string
     */
    public function getDoctrineOrmType()
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
