# saxulum-entity-generator

[![Build Status](https://api.travis-ci.org/saxulum/saxulum-entity-generator.png?branch=master)](https://travis-ci.org/saxulum/saxulum-entity-generator)
[![Total Downloads](https://poser.pugx.org/saxulum/saxulum-entity-generator/downloads.png)](https://packagist.org/packages/saxulum/saxulum-entity-generator)
[![Latest Stable Version](https://poser.pugx.org/saxulum/saxulum-entity-generator/v/stable.png)](https://packagist.org/packages/saxulum/saxulum-entity-generator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/saxulum/saxulum-entity-generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/saxulum/saxulum-entity-generator/?branch=master)

## Features

This library allow to generate out of a mapping php config.

## Requirements

 * php: >=5.3,
 * nikic/php-parser: ~1.1,
 * saxulum/saxulum-phpdoc-generator: ~1.0@rc,
 * symfony/property-access: ~2.3

## Installation

Through [Composer](http://getcomposer.org) as [saxulum/saxulum-entity-generator][1].

## Usage

```{.php}
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

$generator->generate($entityMapping, 'Namespace\To\Generated\Entity', __DIR__.'/../Namespace/To/Generated/Entity');
```

[1]: https://packagist.org/packages/saxulum/saxulum-entity-generator