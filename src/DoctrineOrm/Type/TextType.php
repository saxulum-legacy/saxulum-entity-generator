<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class TextType extends AbstractSimpleType
{
    /**
     * @return string
     */
    public function getDoctrineOrmPhpDocType()
    {
        return 'string';
    }

    /**
     * @return string
     */
    public function getDoctrineOrmType()
    {
        return 'string';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'text';
    }
}
