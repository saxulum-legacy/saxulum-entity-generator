<?php

namespace Saxulum\Tests\EntityGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\EntityGenerator\Mapping\Simple\BigIntFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\BlobFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\DateFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\DateTimeZFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\FloatFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\GuidFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\JsonArrayFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\ObjectFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\SimpleArrayFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\SmallIntFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\TimeFieldMapping;
use Saxulum\EntityGenerator\Type\Relation\Many2ManyInverseSideType;
use Saxulum\EntityGenerator\Type\Relation\Many2ManyOwningSideType;
use Saxulum\EntityGenerator\Type\Relation\Many2OneType;
use Saxulum\EntityGenerator\Type\Relation\One2ManyType;
use Saxulum\EntityGenerator\Type\Relation\One2OneInverseSideType;
use Saxulum\EntityGenerator\Type\Relation\One2OneOwningSideType;
use Saxulum\EntityGenerator\Type\Simple\ArrayType;
use Saxulum\EntityGenerator\Type\Simple\BigIntType;
use Saxulum\EntityGenerator\Type\Simple\BlobType;
use Saxulum\EntityGenerator\Type\Simple\BooleanType;
use Saxulum\EntityGenerator\Type\Simple\DateTimeType;
use Saxulum\EntityGenerator\Type\Simple\DateTimeZType;
use Saxulum\EntityGenerator\Type\Simple\DateType;
use Saxulum\EntityGenerator\Type\Simple\DecimalType;
use Saxulum\EntityGenerator\Type\Simple\FloatType;
use Saxulum\EntityGenerator\Type\Simple\GuidType;
use Saxulum\EntityGenerator\Type\Simple\IdType;
use Saxulum\EntityGenerator\Type\Simple\IntegerType;
use Saxulum\EntityGenerator\Type\Simple\JsonArrayType;
use Saxulum\EntityGenerator\Type\Simple\ObjectType;
use Saxulum\EntityGenerator\Type\Simple\SimpleArrayType;
use Saxulum\EntityGenerator\Type\Simple\SmallIntType;
use Saxulum\EntityGenerator\Type\Simple\StringType;
use Saxulum\EntityGenerator\Type\Simple\TextType;
use Saxulum\EntityGenerator\EntityGenerator;
use Saxulum\EntityGenerator\Mapping\Relation\Many2ManyInverseSideMapping;
use Saxulum\EntityGenerator\Mapping\Relation\Many2ManyOwningSideMapping;
use Saxulum\EntityGenerator\Mapping\Relation\Many2OneMapping;
use Saxulum\EntityGenerator\Mapping\Relation\One2ManyMapping;
use Saxulum\EntityGenerator\Mapping\Relation\One2OneInverseSideMapping;
use Saxulum\EntityGenerator\Mapping\Relation\One2OneOwningSideMapping;
use Saxulum\EntityGenerator\Mapping\Simple\ArrayFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\BooleanFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\DateTimeFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\DecimalFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\IdFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\IntegerFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\StringFieldMapping;
use Saxulum\EntityGenerator\Mapping\Simple\TextFieldMapping;
use Saxulum\EntityGenerator\EntityMapping;
use Saxulum\EntityGenerator\Type\Simple\TimeType;

class EntityGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $generator = new EntityGenerator(new PhpGenerator(), array(
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
        ));

        $entityMapping = new EntityMapping('Product');
        $entityMapping->addField(new ArrayFieldMapping('array'));
        $entityMapping->addField(new BigIntFieldMapping('bigint'));
        $entityMapping->addField(new BlobFieldMapping('blob'));
        $entityMapping->addField(new BooleanFieldMapping('bool'));
        $entityMapping->addField(new DateTimeFieldMapping('datetime'));
        $entityMapping->addField(new DateTimeZFieldMapping('datetimez'));
        $entityMapping->addField(new DateFieldMapping('date'));
        $entityMapping->addField(new DecimalFieldMapping('decimal'));
        $entityMapping->addField(new FloatFieldMapping('float'));
        $entityMapping->addField(new GuidFieldMapping('guid'));
        $entityMapping->addField(new IdFieldMapping('id'));
        $entityMapping->addField(new IntegerFieldMapping('integer'));
        $entityMapping->addField(new JsonArrayFieldMapping('jsonArray'));
        $entityMapping->addField(new ObjectFieldMapping('object', '\stdClass'));
        $entityMapping->addField(new SimpleArrayFieldMapping('simpleArray'));
        $entityMapping->addField(new SmallIntFieldMapping('smallint'));
        $entityMapping->addField(new StringFieldMapping('string'));
        $entityMapping->addField(new TextFieldMapping('text'));
        $entityMapping->addField(new TimeFieldMapping('time'));
        $entityMapping->addField(new Many2ManyOwningSideMapping('unidirectionalMany2Manies', '\Saxulum\Entity\Product'));
        $entityMapping->addField(new Many2ManyOwningSideMapping('owningBidirectionalMany2Manies', '\Saxulum\Entity\Product', 'inverseBidirectionalMany2Manies'));
        $entityMapping->addField(new Many2ManyInverseSideMapping('inverseBidirectionalMany2Manies', '\Saxulum\Entity\Product', 'owningBidirectionalMany2Manies'));
        $entityMapping->addField(new Many2OneMapping('unidirectionalMany2One', '\Saxulum\Entity\Product'));
        $entityMapping->addField(new Many2OneMapping('one', '\Saxulum\Entity\Product', 'manies'));
        $entityMapping->addField(new One2ManyMapping('manies', '\Saxulum\Entity\Product', 'one'));
        $entityMapping->addField(new One2OneOwningSideMapping('unidirectionalOne2One', '\Saxulum\Entity\Product'));
        $entityMapping->addField(new One2OneOwningSideMapping('owningBidirectionalOne2One', '\Saxulum\Entity\Product', 'inverseBidirectionalOne2One'));
        $entityMapping->addField(new One2OneInverseSideMapping('inverseBidirectionalOne2One', '\Saxulum\Entity\Product', 'owningBidirectionalOne2One'));

        $expectedFilePath = __DIR__.'/Entity/';
        $generatedFilePath = __DIR__.'/../generated/Saxulum/Entity/';

        $generator->generate($entityMapping, 'Saxulum\Entity', $generatedFilePath);

        $this->assertFileEquals(
            $expectedFilePath.'Abstract'.$entityMapping->getName().'.php',
            $generatedFilePath.'Base/Abstract'.$entityMapping->getName().'.php'
        );
    }
}
