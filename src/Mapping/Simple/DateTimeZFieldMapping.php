<?php

namespace Saxulum\EntityGenerator\Mapping\Simple;

use Saxulum\EntityGenerator\Mapping\AbstractFieldMapping;

class DateTimeZFieldMapping extends AbstractFieldMapping
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'datetimez';
    }
}
