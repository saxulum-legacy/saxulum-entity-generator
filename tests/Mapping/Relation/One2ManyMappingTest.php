<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Relation;

use Saxulum\EntityGenerator\Mapping\Relation\One2ManyMapping;

class One2ManyMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testDirectionalMapping()
    {
        $mapping = new One2ManyMapping('propertyName', '\Target\Model', 'mappedByProperty');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('\Target\Model', $mapping->getTargetModel());
        $this->assertEquals('mappedByProperty', $mapping->getMappedBy());
    }
}
