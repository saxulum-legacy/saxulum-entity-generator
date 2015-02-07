<?php

namespace Saxulum\Tests\EntityGenerator\Helper;

use Saxulum\EntityGenerator\Helper\StringUtil;

class StringUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testSingularifyWithSinglePossibleResult()
    {
        $this->assertEquals('address', StringUtil::singularify('addresses'));
        $this->assertEquals('property', StringUtil::singularify('properties'));
    }

    public function testSingularifyWithMultiplePossibleResult()
    {
        $this->assertEquals('analys', StringUtil::singularify('analyses'));
        $this->assertEquals('hippopotamus', StringUtil::singularify('hippopotamuses'));
    }
}
