<?php

namespace Saxulum\Tests\ModelGenerator\Mapping\Field\Simple;

use Saxulum\ModelGenerator\Mapping\Simple\ArrayFieldMapping;

class ArrayFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new ArrayFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('array', $mapping->getType());
    }
}
