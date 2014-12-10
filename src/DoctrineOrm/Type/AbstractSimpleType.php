<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\DoctrineOrm\TypeInterface;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;

abstract class AbstractSimpleType implements TypeInterface
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmPropertyNodes($name)
    {
        return array(
            new Property(2,
                array(
                    new PropertyProperty($name)
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new VarRow($this->getDoctrineOrmPhpDocType())
                            ))
                        )
                    )
                )
            ),
        );
    }

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

    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMetadataNodes($name)
    {
        return array(
            new MethodCall(new Variable('builder'), 'addField', array(
                new Arg(new String($name)),
                new Arg(new String($this->getDoctrineOrmType()))
            ))
        );
    }
}
