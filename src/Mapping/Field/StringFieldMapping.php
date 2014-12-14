<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

class StringFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'string';
    }
}
