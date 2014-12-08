<?php

namespace Saxulum\ModelGenerator\Type;

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

class TextType implements TypeInterface
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getProperty($name)
    {
        return array(
            new Property(2, array(
                new PropertyProperty($name)
            ), array(
                'comments' => array(
                    new Comment("\n/**\n * @var string\n */")
                )
            )),
        );
    }

    /**
     * @param string $name
     * @return Node[]
     */
    public function getMethods($name)
    {
        return array(
            new ClassMethod('set' . ucfirst($name), array(
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
            ), array(
                'comments' => array(
                    new Comment("\n/**\n * @param string \$$name\n */")
                )
            )),
            new ClassMethod('get' . ucfirst($name), array(
                'type' => 1,
                'stmts' => array(
                    new Return_(new PropertyFetch(new Variable('this'), $name))
                )
            ), array(
                'comments' => array(
                    new Comment("\n/**\n * @return string\n */")
                )
            )),
        );
    }

    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMetadata($name)
    {
        return array(
            new MethodCall(new Variable('builder'), 'addField', array(
                new Arg(new String($name)),
                new Arg(new String('string'))
            ))
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'text';
    }
}
