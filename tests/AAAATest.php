<?php

namespace Saxulum\Tests\ModelGenerator;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use PhpParser\Error;
use PhpParser\Lexer;
use PhpParser\NodeDumper;
use PhpParser\Parser;

class AAAATest extends \PHPUnit_Framework_TestCase
{
    public function testSample()
    {
        return;
        $parser = new Parser(new Lexer());
        $nodeDumper = new NodeDumper();

        try {
            $stmts = $parser->parse("<?php class A { public function setDate(\\DateTime \$date = null) {}}");

            echo $nodeDumper->dump($stmts), "\n";
        } catch (Error $e) {
            echo 'Parse Error: ', $e->getMessage();
        }
    }
}
