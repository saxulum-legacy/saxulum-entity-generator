<?php

namespace Saxulum\Tests\EntityGenerator;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
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
            $stmts = $parser->parse("<?php \$builder->addField(\$name, 'string');");

            echo $nodeDumper->dump($stmts), "\n";
        } catch (Error $e) {
            echo 'Parse Error: ', $e->getMessage();
        }
    }
}