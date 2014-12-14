<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;

class BooleanType extends AbstractSimpleType
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
                        new Param($name)
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
            new ClassMethod('is' . ucfirst($name),
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

    /**
     * @return string
     */
    public function getDoctrineOrmPhpDocType()
    {
        return 'bool';
    }

    /**
     * @return string
     */
    public function getDoctrineOrmType()
    {
        return 'boolean';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'boolean';
    }
}
