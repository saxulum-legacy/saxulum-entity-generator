<?php

namespace Saxulum\ModelGenerator\Type;

class IntegerType extends AbstractSimpleType
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
