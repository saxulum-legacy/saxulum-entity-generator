<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
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

abstract class AbstractType implements TypeInterface
{
    /**
     * @param string $name
     * @return Node
     */
    public function getPropertyNode($name)
    {
        return new Property(2,
            array(
                new PropertyProperty($name)
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new VarRow($this->getPhpDocType())
                        ))
                    )
                )
            )
        );
    }

    /**
     * @param string $name
     * @return Node|null
     */
    public function getSetterMethodNode($name)
    {
        return new ClassMethod($this->getSetterPrefix() . ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($name, $this->getSetterDefault(), $this->getSetterType())
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
                            new ParamRow($this->getPhpDocType(), $name)
                        ))
                    )
                )
            )
        );
    }

    /**
     * @param string $name
     * @return Node
     */
    public function getGetterMethodNode($name)
    {
        return new ClassMethod($this->getGetterPrefix() . ucfirst($name),
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
                            new ReturnRow($this->getPhpDocType())
                        ))
                    )
                )
            )
        );
    }

    /**
     * @param string $name
     * @return Node
     */
    public function getMetadataNode($name)
    {
        return new MethodCall(new Variable('builder'), 'addField', array(
            new Arg(new String($name)),
            new Arg(new String($this->getOrmType()))
        ));
    }

    /**
     * @param string $name
     * @return Node[]
     */
    public function getMethodsNodes($name)
    {
        return array(
            $this->getSetterMethodNode($name),
            $this->getGetterMethodNode($name)
        );
    }

    /**
     * @return string
     */
    protected function getSetterPrefix()
    {
        return 'set';
    }

    /**
     * @return null|Expr
     */
    protected function getSetterDefault()
    {
        return null;
    }

    /**
     * @return null|string|Name
     */
    protected function getSetterType()
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getGetterPrefix()
    {
        return 'get';
    }

    /**
     * @return string
     */
    abstract protected function getPhpDocType();

    /**
     * @return string
     */
    abstract protected function getOrmType();
}
