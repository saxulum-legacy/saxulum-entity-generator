<?php

namespace Saxulum\Tests\ModelGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\Type\Relation\Many2ManyInverseSideType;
use Saxulum\ModelGenerator\Type\Relation\Many2ManyOwningSideType;
use Saxulum\ModelGenerator\Type\Relation\Many2OneType;
use Saxulum\ModelGenerator\Type\Relation\One2ManyType;
use Saxulum\ModelGenerator\Type\Relation\One2OneInverseSideType;
use Saxulum\ModelGenerator\Type\Relation\One2OneOwningSideType;
use Saxulum\ModelGenerator\Type\Simple\ArrayType;
use Saxulum\ModelGenerator\Type\Simple\BooleanType;
use Saxulum\ModelGenerator\Type\Simple\DateTimeType;
use Saxulum\ModelGenerator\Type\Simple\DecimalType;
use Saxulum\ModelGenerator\Type\Simple\IdType;
use Saxulum\ModelGenerator\Type\Simple\IntegerType;
use Saxulum\ModelGenerator\Type\Simple\StringType;
use Saxulum\ModelGenerator\Type\Simple\TextType;
use Saxulum\ModelGenerator\DoctrineOrmGenerator;
use Saxulum\ModelGenerator\Mapping\Field\Relation\Many2ManyInverseSideMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\Many2ManyOwningSideMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\Many2OneMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2ManyMapping;
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
            new Many2OneType(),
            new Many2ManyOwningSideType(),
            new Many2ManyInverseSideType(),
            new One2ManyType(),
            new One2OneOwningSideType(),
            new One2OneInverseSideType(),

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
        $modelMapping->addField(new Many2ManyOwningSideMapping('unidirectionalMany2Manies', '\Saxulum\Entity\Product'));
        $modelMapping->addField(new Many2ManyOwningSideMapping('owningBidirectionalMany2Manies', '\Saxulum\Entity\Product', 'inverseBidirectionalMany2Manies'));
        $modelMapping->addField(new Many2ManyInverseSideMapping('inverseBidirectionalMany2Manies', '\Saxulum\Entity\Product', 'owningBidirectionalMany2Manies'));
        $modelMapping->addField(new Many2OneMapping('unidirectionalMany2One', '\Saxulum\Entity\Product'));
        $modelMapping->addField(new Many2OneMapping('one', '\Saxulum\Entity\Product', 'manies'));
        $modelMapping->addField(new One2ManyMapping('manies', '\Saxulum\Entity\Product', 'one'));
        $modelMapping->addField(new One2OneOwningSideMapping('unidirectionalOne2One', '\Saxulum\Entity\Product'));
        $modelMapping->addField(new One2OneOwningSideMapping('owningBidirectionalOne2One', '\Saxulum\Entity\Product', 'inverseBidirectionalOne2One'));
        $modelMapping->addField(new One2OneInverseSideMapping('inverseBidirectionalOne2One', '\Saxulum\Entity\Product', 'owningBidirectionalOne2One'));

        $generator->generate($modelMapping, 'Saxulum\Entity', __DIR__.'/../generated/Saxulum/Entity');
    }
}
