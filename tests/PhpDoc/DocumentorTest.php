<?php

namespace Saxulum\Tests\ModelGenerator\PhpDoc;

use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;

class DocumentorTest extends \PHPUnit_Framework_TestCase
{
    public function testForProperty()
    {
        $documentor = new Documentor(array(
            new VarRow('string')
        ));

        $this->assertEquals('/**' . PHP_EOL . ' * @var string' . PHP_EOL . ' */', (string) $documentor);
    }

    public function testForMethod()
    {
        $documentor = new Documentor(array(
            new ParamRow('string', 'var'),
            new ReturnRow('string')
        ));

        $this->assertEquals('/**' . PHP_EOL . ' * @param string $var' . PHP_EOL . ' * @return string' . PHP_EOL . ' */', (string) $documentor);
    }

    public function testWithEmptyArray()
    {
        $this->setExpectedException('\InvalidArgumentException', 'At least one row needs to be given!');

        new Documentor(array());
    }

    public function testWithWrongData()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Rows have to extend AbstractRow!');

        new Documentor(array(new \stdClass()));
    }
}
