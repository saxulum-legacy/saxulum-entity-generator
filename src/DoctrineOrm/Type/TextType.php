<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

class TextType extends AbstractType
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
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'text';
    }
}
