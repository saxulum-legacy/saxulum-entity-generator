<?php

namespace Saxulum\ModelGenerator\Mapping\Simple;

use Saxulum\ModelGenerator\Mapping\AbstractFieldMapping;

class SmallIntFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'smallint';
    }
}
