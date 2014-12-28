<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Simple;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class DateTimeType extends AbstractType
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return null|Expr
     */
    protected function getSetterDefault(FieldMappingInterface $fieldMapping)
    {
        return new ConstFetch(new Name('null'));
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return null|string
     */
    protected function getSetterType(FieldMappingInterface $fieldMapping)
    {
        return new Name('\DateTime');
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return '\DateTime';
    }

    /**
     * @return string
     */
    public function getOrmType()
    {
        return 'datetime';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'datetime';
    }
}
