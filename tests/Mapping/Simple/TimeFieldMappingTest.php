<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Field\Simple;

use Saxulum\EntityGenerator\Mapping\Simple\TimeFieldMapping;

class TimeFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new TimeFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('time', $mapping->getType());
    }
}
