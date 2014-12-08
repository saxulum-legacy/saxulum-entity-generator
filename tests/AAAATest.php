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
        $parser = new Parser(new Lexer());
        $nodeDumper = new NodeDumper();

        try {
            $stmts = $parser->parse('<?php
                class Test implements FooInterface, BarInterface
                {
                    /**
                     * @var string
                     */
                    protected $name;
                }');
            //$stmts = $parser->parse("<?php \$builder->addField(\$name, 'string');");

            echo $nodeDumper->dump($stmts), "\n";
        } catch (Error $e) {
            echo 'Parse Error: ', $e->getMessage();
        }
    }
}
