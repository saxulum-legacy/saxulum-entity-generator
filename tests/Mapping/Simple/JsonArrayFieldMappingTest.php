<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Field\Simple;

use Saxulum\EntityGenerator\Mapping\Simple\JsonArrayFieldMapping;

class JsonArrayFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new JsonArrayFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('json_array', $mapping->getType());
    }
}
