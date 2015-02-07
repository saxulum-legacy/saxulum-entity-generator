<?php

namespace Saxulum\Tests\ModelGenerator\Mapping\Field\Simple;

use Saxulum\ModelGenerator\Mapping\Simple\FloatFieldMapping;

class FloatFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new FloatFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('float', $mapping->getType());
    }
}
