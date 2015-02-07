<?php

namespace Saxulum\Tests\ModelGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\Mapping\Simple\BigIntFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\BlobFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\DateFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\DateTimeZFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\FloatFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\GuidFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\JsonArrayFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\ObjectFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\SimpleArrayFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\SmallIntFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\TimeFieldMapping;
use Saxulum\ModelGenerator\Type\Relation\Many2ManyInverseSideType;
use Saxulum\ModelGenerator\Type\Relation\Many2ManyOwningSideType;
use Saxulum\ModelGenerator\Type\Relation\Many2OneType;
use Saxulum\ModelGenerator\Type\Relation\One2ManyType;
use Saxulum\ModelGenerator\Type\Relation\One2OneInverseSideType;
use Saxulum\ModelGenerator\Type\Relation\One2OneOwningSideType;
use Saxulum\ModelGenerator\Type\Simple\ArrayType;
use Saxulum\ModelGenerator\Type\Simple\BigIntType;
use Saxulum\ModelGenerator\Type\Simple\BlobType;
use Saxulum\ModelGenerator\Type\Simple\BooleanType;
use Saxulum\ModelGenerator\Type\Simple\DateTimeType;
use Saxulum\ModelGenerator\Type\Simple\DateTimeZType;
use Saxulum\ModelGenerator\Type\Simple\DateType;
use Saxulum\ModelGenerator\Type\Simple\DecimalType;
use Saxulum\ModelGenerator\Type\Simple\FloatType;
use Saxulum\ModelGenerator\Type\Simple\GuidType;
use Saxulum\ModelGenerator\Type\Simple\IdType;
use Saxulum\ModelGenerator\Type\Simple\IntegerType;
use Saxulum\ModelGenerator\Type\Simple\JsonArrayType;
use Saxulum\ModelGenerator\Type\Simple\ObjectType;
use Saxulum\ModelGenerator\Type\Simple\SimpleArrayType;
use Saxulum\ModelGenerator\Type\Simple\SmallIntType;
use Saxulum\ModelGenerator\Type\Simple\StringType;
use Saxulum\ModelGenerator\Type\Simple\TextType;
use Saxulum\ModelGenerator\DoctrineOrmGenerator;
use Saxulum\ModelGenerator\Mapping\Relation\Many2ManyInverseSideMapping;
use Saxulum\ModelGenerator\Mapping\Relation\Many2ManyOwningSideMapping;
use Saxulum\ModelGenerator\Mapping\Relation\Many2OneMapping;
use Saxulum\ModelGenerator\Mapping\Relation\One2ManyMapping;
use Saxulum\ModelGenerator\Mapping\Relation\One2OneInverseSideMapping;
use Saxulum\ModelGenerator\Mapping\Relation\One2OneOwningSideMapping;
use Saxulum\ModelGenerator\Mapping\Simple\ArrayFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\BooleanFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\DateTimeFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\DecimalFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\IdFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\IntegerFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\StringFieldMapping;
use Saxulum\ModelGenerator\Mapping\Simple\TextFieldMapping;
use Saxulum\ModelGenerator\EntityMapping;
use Saxulum\ModelGenerator\Type\Simple\TimeType;

class DoctrineOrmGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $types = array(
            new ArrayType(),
            new BigIntType(),
            new BlobType(),
            new BooleanType(),
            new DateTimeType(),
            new DateTimeZType(),
            new DateType(),
            new DecimalType(),
            new FloatType(),
            new GuidType(),
            new IdType(),
            new IntegerType(),
            new JsonArrayType(),
            new ObjectType(),
            new SimpleArrayType(),
            new SmallIntType(),
            new StringType(),
            new TextType(),
            new TimeType(),
            new Many2OneType(),
            new Many2ManyOwningSideType(),
            new Many2ManyInverseSideType(),
            new One2ManyType(),
            new One2OneOwningSideType(),
            new One2OneInverseSideType(),
        );

        $phpGenerator = new PhpGenerator();
        $generator = new DoctrineOrmGenerator($phpGenerator, $types);

        $modelMapping = new EntityMapping('Product');
        $modelMapping->addField(new ArrayFieldMapping('array'));
        $modelMapping->addField(new BigIntFieldMapping('bigint'));
        $modelMapping->addField(new BlobFieldMapping('blob'));
        $modelMapping->addField(new BooleanFieldMapping('bool'));
        $modelMapping->addField(new DateTimeFieldMapping('datetime'));
        $modelMapping->addField(new DateTimeZFieldMapping('datetimez'));
        $modelMapping->addField(new DateFieldMapping('date'));
        $modelMapping->addField(new DecimalFieldMapping('decimal'));
        $modelMapping->addField(new FloatFieldMapping('float'));
        $modelMapping->addField(new GuidFieldMapping('guid'));
        $modelMapping->addField(new IdFieldMapping('id'));
        $modelMapping->addField(new IntegerFieldMapping('integer'));
        $modelMapping->addField(new JsonArrayFieldMapping('jsonArray'));
        $modelMapping->addField(new ObjectFieldMapping('object', '\stdClass'));
        $modelMapping->addField(new SimpleArrayFieldMapping('simpleArray'));
        $modelMapping->addField(new SmallIntFieldMapping('smallint'));
        $modelMapping->addField(new StringFieldMapping('string'));
        $modelMapping->addField(new TextFieldMapping('text'));
        $modelMapping->addField(new TimeFieldMapping('time'));
        $modelMapping->addField(new Many2ManyOwningSideMapping('unidirectionalMany2Manies', '\Saxulum\Entity\Product'));
        $modelMapping->addField(new Many2ManyOwningSideMapping('owningBidirectionalMany2Manies', '\Saxulum\Entity\Product', 'inverseBidirectionalMany2Manies'));
        $modelMapping->addField(new Many2ManyInverseSideMapping('inverseBidirectionalMany2Manies', '\Saxulum\Entity\Product', 'owningBidirectionalMany2Manies'));
        $modelMapping->addField(new Many2OneMapping('unidirectionalMany2One', '\Saxulum\Entity\Product'));
        $modelMapping->addField(new Many2OneMapping('one', '\Saxulum\Entity\Product', 'manies'));
        $modelMapping->addField(new One2ManyMapping('manies', '\Saxulum\Entity\Product', 'one'));
        $modelMapping->addField(new One2OneOwningSideMapping('unidirectionalOne2One', '\Saxulum\Entity\Product'));
        $modelMapping->addField(new One2OneOwningSideMapping('owningBidirectionalOne2One', '\Saxulum\Entity\Product', 'inverseBidirectionalOne2One'));
        $modelMapping->addField(new One2OneInverseSideMapping('inverseBidirectionalOne2One', '\Saxulum\Entity\Product', 'owningBidirectionalOne2One'));

        $expectedFilePath = __DIR__.'/Entity/';
        $generatedFilePath = __DIR__.'/../generated/Saxulum/Entity/';

        $generator->generate($modelMapping, 'Saxulum\Entity', $generatedFilePath);

        $this->assertFileEquals(
            $expectedFilePath.'Abstract'.$modelMapping->getName().'.php',
            $generatedFilePath.'Base/Abstract'.$modelMapping->getName().'.php'
        );
    }
}
