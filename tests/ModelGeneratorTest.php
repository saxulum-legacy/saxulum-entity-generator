<?php

namespace Saxulum\Tests\ModelGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\Generator;
use Saxulum\ModelGenerator\Mapping\FieldMapping;
use Saxulum\ModelGenerator\Mapping\ModelMapping;
use Saxulum\ModelGenerator\Type\IntegerType;
use Saxulum\ModelGenerator\Type\TextType;

class ModelGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testModelGeneration()
    {
        $types = array(
            new IntegerType(),
            new TextType(),
        );

        $phpGenerator = new PhpGenerator();
        $generator = new Generator($phpGenerator, $types);

        $modelMapping = new ModelMapping('Product');
        $modelMapping->addField(new FieldMapping('id', 'integer'));
        $modelMapping->addField(new FieldMapping('name', 'text'));

        $generator->generateModel($modelMapping);
    }
}
