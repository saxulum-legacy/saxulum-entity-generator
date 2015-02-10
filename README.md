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
$entityMapping
    ->addField(new ArrayFieldMapping('array'))
    ->addField(new BigIntFieldMapping('bigint'))
    ->addField(new BlobFieldMapping('blob'))
    ->addField(new BooleanFieldMapping('bool'))
    ->addField(new DateTimeFieldMapping('datetime'))
    ->addField(new DateTimeZFieldMapping('datetimez'))
    ->addField(new DateFieldMapping('date'))
    ->addField(new DecimalFieldMapping('decimal'))
    ->addField(new FloatFieldMapping('float'))
    ->addField(new GuidFieldMapping('guid'))
    ->addField(new IdFieldMapping('id'))
    ->addField(new IntegerFieldMapping('integer'))
    ->addField(new JsonArrayFieldMapping('jsonArray'))
    ->addField(new ObjectFieldMapping('object', '\stdClass'))
    ->addField(new SimpleArrayFieldMapping('simpleArray'))
    ->addField(new SmallIntFieldMapping('smallint'))
    ->addField(new StringFieldMapping('string'))
    ->addField(new TextFieldMapping('text'))
    ->addField(new TimeFieldMapping('time'))
    ->addField(new Many2ManyOwningSideMapping(
        'unidirectionalMany2Manies',
        '\Saxulum\Entity\Product'
    ))
    ->addField(new Many2ManyOwningSideMapping(
        'owningBidirectionalMany2Manies',
        '\Saxulum\Entity\Product',
        'inverseBidirectionalMany2Manies'
    ))
    ->addField(new Many2ManyInverseSideMapping(
        'inverseBidirectionalMany2Manies',
        '\Saxulum\Entity\Product',
        'owningBidirectionalMany2Manies'
    ))
    ->addField(new Many2OneMapping(
        'unidirectionalMany2One',
        '\Saxulum\Entity\Product'
    ))
    ->addField(new Many2OneMapping(
        'one',
        '\Saxulum\Entity\Product',
        'manies'
    ))
    ->addField(new One2ManyMapping(
        'manies',
        '\Saxulum\Entity\Product',
        'one'
    ))
    ->addField(new One2OneOwningSideMapping(
        'unidirectionalOne2One',
        '\Saxulum\Entity\Product'
    ))
    ->addField(new One2OneOwningSideMapping(
        'owningBidirectionalOne2One',
        '\Saxulum\Entity\Product',
        'inverseBidirectionalOne2One'
    ))
    ->addField(new One2OneInverseSideMapping(
        'inverseBidirectionalOne2One',
        '\Saxulum\Entity\Product',
        'owningBidirectionalOne2One'
    ))
;
```

[1]: https://packagist.org/packages/saxulum/saxulum-entity-generator