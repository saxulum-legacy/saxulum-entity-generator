<?php

namespace Saxulum\Tests\EntityGenerator\Mapping\Relation;

use Saxulum\EntityGenerator\Mapping\Relation\Many2ManyInverseSideMapping;

class Many2ManyInverseSideMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testDirectionalMapping()
    {
        $mapping = new Many2ManyInverseSideMapping('propertyName', '\Target\Model', 'mappedByProperty');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('\Target\Model', $mapping->getTargetModel());
        $this->assertEquals('mappedByProperty', $mapping->getMappedBy());
    }
}
