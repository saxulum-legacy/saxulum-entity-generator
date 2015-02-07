<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Field\Simple;

use Saxulum\EntityGenerator\Mapping\Simple\SimpleArrayFieldMapping;

class SimpleArrayFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new SimpleArrayFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('simple_array', $mapping->getType());
    }
}
