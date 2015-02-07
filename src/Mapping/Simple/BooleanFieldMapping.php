<?php

namespace Saxulum\ModelGenerator\Mapping\Simple;

use Saxulum\ModelGenerator\Mapping\AbstractFieldMapping;

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
