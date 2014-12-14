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

class IdType extends AbstractType
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getMethodsNodes($name)
    {
        return array(
            $this->getGetterMethodNode($name)
        );
    }

    /**
     * @param string $name
     * @return Node
     */
    public function getMetadataNode($name)
    {
        return new MethodCall(
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
        );
    }

    /**
     * @return string
     */
    protected function getPhpDocType()
    {
        return 'int';
    }

    /**
     * @return string
     */
    protected function getOrmType()
    {
        return 'id';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id';
    }
}
