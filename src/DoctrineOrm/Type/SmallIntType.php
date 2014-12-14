<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class SmallIntType extends AbstractSimpleType
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
        return 'smallint';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'smallint';
    }
}
