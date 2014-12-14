<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;

class DateTimeType extends AbstractType
{
    /**
     * @return null|Expr
     */
    protected function getSetterDefault()
    {
        return new ConstFetch(new Name('null'));
    }

    /**
     * @return null|string|Name
     */
    protected function getSetterType()
    {
        return new Name('\DateTime');
    }

    /**
     * @return string
     */
    public function getPhpDocType()
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
