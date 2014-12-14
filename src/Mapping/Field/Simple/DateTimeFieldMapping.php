<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Simple;

use Saxulum\ModelGenerator\Mapping\Field\AbstractFieldMapping;

class DateTimeFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'datetime';
    }
}
