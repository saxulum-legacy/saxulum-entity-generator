<?php

namespace Saxulum\ModelGenerator\Type;

class TextType extends AbstractSimpleType
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
