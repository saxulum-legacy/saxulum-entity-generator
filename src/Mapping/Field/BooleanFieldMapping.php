<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

class BooleanFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'boolean';
    }
}
