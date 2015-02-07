<?php

namespace Saxulum\EntityGenerator\Mapping\Simple;

use Saxulum\EntityGenerator\Mapping\AbstractFieldMapping;

class FloatFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'float';
    }
}
