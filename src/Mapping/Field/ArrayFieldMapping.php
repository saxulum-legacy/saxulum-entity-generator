<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

class ArrayFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'array';
    }
}
