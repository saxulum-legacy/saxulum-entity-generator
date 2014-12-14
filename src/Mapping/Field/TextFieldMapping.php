<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

class TextFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'text';
    }
}
