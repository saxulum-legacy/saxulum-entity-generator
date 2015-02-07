<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Field\Simple;

use Saxulum\EntityGenerator\Mapping\Simple\TextFieldMapping;

class TextFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new TextFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('text', $mapping->getType());
    }
}
