<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Field\Simple;

use Saxulum\EntityGenerator\Mapping\Simple\ObjectFieldMapping;

class ObjectFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new ObjectFieldMapping('propertyName', '\stdClass');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('object', $mapping->getType());
        $this->assertEquals('\stdClass', $mapping->getClass());
    }
}
