<?php

namespace Saxulum\Tests\EntityGenerator;

use PhpParser\Error;
use PhpParser\Lexer;
use PhpParser\NodeDumper;
use PhpParser\Parser;

class SampleTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $parser = new Parser(new Lexer());
        $nodeDumper = new NodeDumper();

        try {
            //$stmts = $parser->parse('<?php class Test { protected $name; protected $value; }');
            $stmts = $parser->parse('<?php class Test { protected $name; public function setName($name){ $this->name = $name; } public function getName() { return $this->name; }}');

            echo $nodeDumper->dump($stmts), "\n";
        } catch (Error $e) {
            echo 'Parse Error: ', $e->getMessage();
        }
    }
}