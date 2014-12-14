<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class BigIntType extends AbstractSimpleType
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
        return 'bigint';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bigint';
    }
}
