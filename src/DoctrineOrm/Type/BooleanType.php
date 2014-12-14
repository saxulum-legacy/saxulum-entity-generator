<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class BooleanType extends AbstractType
{
    /**
     * @return string
     */
    public function getPhpDocType()
    {
        return 'bool';
    }

    /**
     * @return string
     */
    public function getGetterPrefix()
    {
        return 'is';
    }

    /**
     * @return string
     */
    public function getOrmType()
    {
        return 'boolean';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'boolean';
    }
}
