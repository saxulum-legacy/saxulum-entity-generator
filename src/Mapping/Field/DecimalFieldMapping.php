<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

class DecimalFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'decimal';
    }
}
