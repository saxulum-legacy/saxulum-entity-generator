<?php

namespace Saxulum\ModelGenerator\Mapping\Simple;

use Saxulum\ModelGenerator\Mapping\AbstractFieldMapping;

class SimpleArrayFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'simple_array';
    }
}
