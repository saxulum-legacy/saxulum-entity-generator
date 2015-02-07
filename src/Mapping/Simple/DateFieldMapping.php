<?php

namespace Saxulum\EntityGenerator\Mapping\Simple;

use Saxulum\EntityGenerator\Mapping\AbstractFieldMapping;

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
