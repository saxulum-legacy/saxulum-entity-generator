<?php

namespace Saxulum\ModelGenerator\Mapping\Simple;

use Saxulum\ModelGenerator\Mapping\AbstractFieldMapping;

class DateFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'date';
    }
}
