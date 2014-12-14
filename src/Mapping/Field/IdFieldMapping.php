<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

class IdFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'id';
    }
}
