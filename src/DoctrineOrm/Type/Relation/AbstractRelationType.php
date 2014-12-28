<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\DoctrineOrm\TypeInterface;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;

abstract class AbstractRelationType implements TypeInterface
{
    /**
     * @param string $returnString
     * @return Node
     */
    protected function getGetterMethodNode($name, $returnString)
    {
        return new ClassMethod('get' . ucfirst($name),
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
                            new ReturnRow($returnString)
                        ))
                    )
                )
            )
        );
    }
}
