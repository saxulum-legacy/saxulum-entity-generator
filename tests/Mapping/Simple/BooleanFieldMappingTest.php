<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Field\Simple;

use Saxulum\EntityGenerator\Mapping\Simple\BooleanFieldMapping;

class BooleanFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new BooleanFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('boolean', $mapping->getType());
    }
}
