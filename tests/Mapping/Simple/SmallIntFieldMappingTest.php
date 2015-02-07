<?php

namespace Saxulum\Tests\ModelGenerator\Mapping\Field\Simple;

use Saxulum\ModelGenerator\Mapping\Simple\SmallIntFieldMapping;

class SmallIntFieldMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testMapping()
    {
        $mapping = new SmallIntFieldMapping('propertyName');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('smallint', $mapping->getType());
    }
}
