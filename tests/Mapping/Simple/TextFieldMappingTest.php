<?php

namespace Saxulum\Tests\ModelGenerator\Mapping\Field\Simple;

use Saxulum\ModelGenerator\Mapping\Simple\TextFieldMapping;

class TextFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new TextFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('text', $mapping->getType());
    }
}
