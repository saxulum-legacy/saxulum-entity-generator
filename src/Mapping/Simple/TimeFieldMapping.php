<?php

namespace Saxulum\ModelGenerator\Mapping\Simple;

use Saxulum\ModelGenerator\Mapping\AbstractFieldMapping;

class TimeFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'time';
    }
}
