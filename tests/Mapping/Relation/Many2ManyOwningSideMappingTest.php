<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Relation;

use Saxulum\EntityGenerator\Mapping\Relation\Many2ManyOwningSideMapping;

class Many2ManyOwningSideMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testDirectionalMapping()
    {
        $mapping = new Many2ManyOwningSideMapping('propertyName', '\Target\Model', 'inversedByProperty');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('\Target\Model', $mapping->getTargetModel());
        $this->assertEquals('inversedByProperty', $mapping->getInversedBy());
    }

    public function testUnidirectionalMapping()
    {
        $mapping = new Many2ManyOwningSideMapping('propertyName', '\Target\Model');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('\Target\Model', $mapping->getTargetModel());
        $this->assertEquals(null, $mapping->getInversedBy());
    }
}
