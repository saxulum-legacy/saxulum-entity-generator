<?php

namespace Saxulum\Tests\ModelGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Relation\One2OneInverseSide;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Relation\One2OneOwningSide;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\ArrayType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\BooleanType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\DateTimeType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\DecimalType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\IdType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\IntegerType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\StringType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\Simple\TextType;
use Saxulum\ModelGenerator\DoctrineOrmGenerator;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneInverseSideMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneOwningSideMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\ArrayFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\BooleanFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\DateTimeFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\DecimalFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\IdFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\IntegerFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\StringFieldMapping;
use Saxulum\ModelGenerator\Mapping\Field\Simple\TextFieldMapping;
use Saxulum\ModelGenerator\Mapping\ModelMapping;

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
        $generator = new DoctrineOrmGenerator($phpGenerator, $types);

        $modelMapping = new ModelMapping('Product');
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

        $generator->generate($modelMapping, 'Saxulum\Entity', __DIR__ . '/../generated/Entity');
    }
}
