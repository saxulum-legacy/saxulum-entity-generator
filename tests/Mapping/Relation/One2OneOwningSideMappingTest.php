<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Relation;

use Saxulum\EntityGenerator\Mapping\Relation\One2OneOwningSideMapping;

class One2OneOwningSideMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testDirectionalMapping()
    {
        $mapping = new One2OneOwningSideMapping('propertyName', '\Target\Model', 'inversedByProperty');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('\Target\Model', $mapping->getTargetModel());
        $this->assertEquals('inversedByProperty', $mapping->getInversedBy());
    }

    public function testUnidirectionalMapping()
    {
        $mapping = new One2OneOwningSideMapping('propertyName', '\Target\Model');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('\Target\Model', $mapping->getTargetModel());
        $this->assertEquals(null, $mapping->getInversedBy());
    }
}
