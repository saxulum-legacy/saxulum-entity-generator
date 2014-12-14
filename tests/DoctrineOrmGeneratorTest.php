<?php

namespace Saxulum\Tests\ModelGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\DoctrineOrm\Generator;
use Saxulum\ModelGenerator\DoctrineOrm\Type\IntegerIdType;
use Saxulum\ModelGenerator\Mapping\FieldMapping;
use Saxulum\ModelGenerator\Mapping\ModelMapping;
use Saxulum\ModelGenerator\DoctrineOrm\Type\IntegerType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\StringType;

class DoctrineOrmGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $types = array(
            new IntegerIdType(),
            new IntegerType(),
            new StringType(),
        );

        $phpGenerator = new PhpGenerator();
        $generator = new Generator($phpGenerator, $types);

        $modelMapping = new ModelMapping('Product', 'Saxulum', __DIR__ . '/../generated');
        $modelMapping->addField(new FieldMapping('id', 'integerid'));
        $modelMapping->addField(new FieldMapping('name', 'string'));
        $modelMapping->addField(new FieldMapping('value', 'integer'));

        $generator->generate($modelMapping);
    }
}
