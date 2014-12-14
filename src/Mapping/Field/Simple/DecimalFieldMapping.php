<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Simple;

use Saxulum\ModelGenerator\Mapping\Field\AbstractFieldMapping;

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
