<?php

namespace Saxulum\Tests\ModelGenerator;

use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\DoctrineOrm\Generator;
use Saxulum\ModelGenerator\DoctrineOrm\Type\BigIntType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\BooleanType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DateTimeType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DateTimeZType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DateType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\DecimalType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\IntegerIdType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\SmallIntType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\TextType;
use Saxulum\ModelGenerator\DoctrineOrm\Type\TimeType;
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
            new StringType(),
            new IntegerType(),
            new SmallIntType(),
            new BigIntType(),
            new BooleanType(),
            new DecimalType(),
            new DateType(),
            new TimeType(),
            new DateTimeType(),
            new DateTimeZType(),
            new TextType()
        );

        $phpGenerator = new PhpGenerator();
        $generator = new Generator($phpGenerator, $types);

        $modelMapping = new ModelMapping('Product', 'Saxulum', __DIR__ . '/../generated');
        $modelMapping->addField(new FieldMapping('id', 'integerid'));
        $modelMapping->addField(new FieldMapping('string', 'string'));
        $modelMapping->addField(new FieldMapping('integer', 'integer'));
        $modelMapping->addField(new FieldMapping('smallint', 'smallint'));
        $modelMapping->addField(new FieldMapping('bigint', 'bigint'));
        $modelMapping->addField(new FieldMapping('boolean', 'boolean'));
        $modelMapping->addField(new FieldMapping('decimal', 'decimal'));
        $modelMapping->addField(new FieldMapping('date', 'date'));
        $modelMapping->addField(new FieldMapping('time', 'time'));
        $modelMapping->addField(new FieldMapping('datetime', 'datetime'));
        $modelMapping->addField(new FieldMapping('datetimez', 'datetimez'));
        $modelMapping->addField(new FieldMapping('text', 'text'));

        $generator->generate($modelMapping);
    }
}
