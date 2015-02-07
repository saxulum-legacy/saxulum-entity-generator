<?php

namespace Saxulum\EntityGenerator\Mapping\Simple;

use Saxulum\EntityGenerator\Mapping\AbstractFieldMapping;

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
