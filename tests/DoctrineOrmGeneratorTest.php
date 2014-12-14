<?php

namespace Saxulum\Tests\ModelGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\DoctrineOrm\Generator;
use Saxulum\ModelGenerator\DoctrineOrm\Type\ArrayType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\BigIntType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\BooleanType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DateTimeType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DateTimeZType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DateType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DecimalType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\IdType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\ObjectType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Relation\One2OneInverseSide;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Relation\One2OneOwningSide;
use Saxulum\ModelGenerator\DoctrineOrm\Type\SmallIntType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\TextType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\TimeType;
use Saxulum\ModelGenerator\Mapping\Field\ArrayFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\BooleanFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\DateTimeFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\DecimalFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\IdFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\IntegerFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\ObjectFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneInverseSideMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneOwningSideMapping;
use Saxulum\ModelGenerator\Mapping\Field\StringFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\TextFieldMapping;
use Saxulum\ModelGenerator\Mapping\FieldMapping;
use Saxulum\ModelGenerator\Mapping\ModelMapping;
use Saxulum\ModelGenerator\DoctrineOrm\Type\IntegerType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\StringType;

class DoctrineOrmGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $types = array(
            new IdType(),
            new ArrayType(),
            new BooleanType(),
            new DecimalType(),
            new DateTimeType(),
            new IntegerType(),
            new StringType(),
            new TextType(),
            new One2OneOwningSide(),
            new One2OneInverseSide()
        );

        $phpGenerator = new PhpGenerator();
        $generator = new Generator($phpGenerator, $types);

        $modelMapping = new ModelMapping('Product', 'Saxulum', __DIR__ . '/../generated');
        $modelMapping->addField(new IdFieldMapping('id'));
        $modelMapping->addField(new ArrayFieldMapping('array'));
        $modelMapping->addField(new BooleanFieldMapping('bool'));
        $modelMapping->addField(new DecimalFieldMapping('decimal'));
        $modelMapping->addField(new DateTimeFieldMapping('datetime'));
        $modelMapping->addField(new IntegerFieldMapping('integer'));
        $modelMapping->addField(new StringFieldMapping('string'));
        $modelMapping->addField(new TextFieldMapping('text'));
        $modelMapping->addField(new One2OneOwningSideMapping('unidirectionalOne2One', '\Saxulum\Entity\Product'));
        $modelMapping->addField(new One2OneOwningSideMapping('owningDidirectionalOne2One', '\Saxulum\Entity\Product', 'inverseDidirectionalOne2One'));
        $modelMapping->addField(new One2OneInverseSideMapping('inverseDidirectionalOne2One', '\Saxulum\Entity\Product', 'owningDidirectionalOne2One'));

        $generator->generate($modelMapping);
    }
}
