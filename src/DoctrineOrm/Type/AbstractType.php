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
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;

abstract class AbstractType implements TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getPropertyNode(FieldMappingInterface $fieldMapping)
    {
        return new Property(2,
            array(
                new PropertyProperty($fieldMapping->getName())
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new VarRow($this->getPhpDocType($fieldMapping))
                        ))
                    )
                )
            )
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node|null
     */
    public function getSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        $name = $fieldMapping->getName();

        return new ClassMethod($this->getSetterPrefix() . ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($fieldMapping->getName(), $this->getSetterDefault($fieldMapping), $this->getSetterType($fieldMapping))
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
                            new ParamRow($this->getPhpDocType($fieldMapping), $name)
                        ))
                    )
                )
            )
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getGetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        $name = $fieldMapping->getName();

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
                            new ReturnRow($this->getPhpDocType($fieldMapping))
                        ))
                    )
                )
            )
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getMetadataNode(FieldMappingInterface $fieldMapping)
    {
        return new MethodCall(new Variable('builder'), 'addField', array(
            new Arg(new String($fieldMapping->getName())),
            new Arg(new String($this->getOrmType()))
        ));
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            $this->getSetterMethodNode($fieldMapping),
            $this->getGetterMethodNode($fieldMapping)
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
     * @param FieldMappingInterface $fieldMapping
     * @return null|Expr
     */
    protected function getSetterDefault(FieldMappingInterface $fieldMapping)
    {
        return null;
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return null|string|Name
     */
    protected function getSetterType(FieldMappingInterface $fieldMapping)
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
     * @param FieldMappingInterface $fieldMapping
     * @return string
     */
    abstract protected function getPhpDocType(FieldMappingInterface $fieldMapping);

    /**
     * @return string
     */
    abstract protected function getOrmType();
}
