<?php

namespace Saxulum\Tests\ModelGenerator\Mapping\Relation;

use Saxulum\ModelGenerator\Mapping\Relation\One2OneInverseSideMapping;

class One2OneInverseSideMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testDirectionalMapping()
    {
        $mapping = new One2OneInverseSideMapping('propertyName', '\Target\Model', 'mappedByProperty');

        $this->assertEquals('propertyName', $mapping->getName());
        $this->assertEquals('\Target\Model', $mapping->getTargetModel());
        $this->assertEquals('mappedByProperty', $mapping->getMappedBy());
    }
}
