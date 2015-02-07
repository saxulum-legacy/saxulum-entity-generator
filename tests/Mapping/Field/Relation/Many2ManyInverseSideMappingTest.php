<?php

namespace Saxulum\Tests\ModelGenerator\Mapping\Field\Relation;

use Saxulum\ModelGenerator\Mapping\Field\Relation\Many2ManyInverseSideMapping;

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