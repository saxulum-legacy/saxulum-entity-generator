<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

class IntegerFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'integer';
    }
}
