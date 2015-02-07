<?php

namespace Saxulum\Tests\ModelGenerator\Mapping\Field\Simple;

use Saxulum\ModelGenerator\Mapping\Simple\DateTimeZFieldMapping;

class DateTimeZFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new DateTimeZFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('datetimez', $mapping->getType());
    }
}
