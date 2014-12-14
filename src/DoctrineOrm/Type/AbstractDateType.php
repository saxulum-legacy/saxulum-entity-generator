<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;

abstract class AbstractDateType extends AbstractSimpleType
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMethodNodes($name)
    {
        return array(
            new ClassMethod('set' . ucfirst($name),
                array(
                    'type' => 1,
                    'params' => array(
                        new Param($name, new ConstFetch(new Name('null')), new FullyQualified('DateTime'))
                    ),
                    'stmts' => array(
                        new Assign(
                            new PropertyFetch(new Variable('this'), $name),
                            new Variable($name)
                        )
                    )
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new ParamRow($this->getDoctrineOrmPhpDocType(), $name)
                            ))
                        )
                    )
                )
            ),
            new ClassMethod('get' . ucfirst($name),
                array(
                    'type' => 1,
                    'stmts' => array(
                        new Return_(new PropertyFetch(new Variable('this'), $name))
                    )
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new ReturnRow($this->getDoctrineOrmPhpDocType())
                            ))
                        )
                    )
                )
            ),
        );
    }
}
