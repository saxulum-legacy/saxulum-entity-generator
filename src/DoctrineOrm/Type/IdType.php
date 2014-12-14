<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\DoctrineOrm\TypeInterface;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;

class IdType implements TypeInterface
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
                                new VarRow('int')
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
                                new ReturnRow('int')
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
            new MethodCall(
                new MethodCall(
                    new MethodCall(
                        new MethodCall(new Variable('builder'), 'createField', array(
                            new Arg(new String($name)),
                            new Arg(new String('integer'))
                        )),
                        'isPrimaryKey'
                    ),
                    'generatedValue'
                ),
                'build'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id';
    }
}
