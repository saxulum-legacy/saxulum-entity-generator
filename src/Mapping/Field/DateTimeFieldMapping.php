<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

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
