<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\DoctrineOrm\TypeInterface;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\AbstractOne2OneMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneOwningSideMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;

abstract class AbstractOne2One implements TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getPropertyNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof AbstractOne2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractOne2OneMapping!');
        }

        return new Property(2,
            array(
                new PropertyProperty($fieldMapping->getName())
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new VarRow($fieldMapping->getTargetModel())
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
    public function getConstructNode(FieldMappingInterface $fieldMapping)
    {
        return null;
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @param string $relatedName
     * @return Node
     */
    protected function getBidiretionalSetterMethodNode(FieldMappingInterface $fieldMapping, $relatedName)
    {
        if (!$fieldMapping instanceof AbstractOne2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractOne2OneMapping!');
        }

        $name = $fieldMapping->getName();
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('set' . ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($name, new ConstFetch(new Name('null')), new Name($targetModel)),
                    new Param('stopPropagation', new ConstFetch(new Name('false')))
                ),
                'stmts' => array(
                    new Node\Stmt\If_(
                        new Expr\BooleanNot(
                            new Variable('stopPropagation')
                        ),
                        array(
                            'stmts' => array(
                                new Node\Stmt\If_(
                                    new Expr\BinaryOp\NotIdentical(
                                        new ConstFetch(new Name('null')),
                                        new PropertyFetch(new Variable('this'), $name)
                                    ),
                                    array(
                                        'stmts' => array(
                                            new MethodCall(
                                                new PropertyFetch(new Variable('this'), $name),
                                                'set' . ucfirst($relatedName),
                                                array(
                                                    new Arg(new ConstFetch(new Name('null'))),
                                                    new Arg(new ConstFetch(new Name('true')))
                                                )
                                            )
                                        )
                                    )
                                ),
                                new Node\Stmt\If_(
                                    new Expr\BinaryOp\NotIdentical(
                                        new ConstFetch(new Name('null')),
                                        new Variable($name)
                                    ),
                                    array(
                                        'stmts' => array(
                                            new MethodCall(
                                                new Variable($name),
                                                'set' . ucfirst($relatedName),
                                                array(
                                                    new Arg(new Variable('this')),
                                                    new Arg(new ConstFetch(new Name('true')))
                                                )
                                            )
                                        )
                                    )
                                ),
                            ),
                        )
                    ),
                    new Assign(
                        new PropertyFetch(new Variable('this'), $name),
                        new Variable($name)
                    ),
                    new Return_(new Variable('this'))
                )
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new ParamRow($targetModel, $name),
                            new ParamRow('bool', 'stopPropagation'),
                            new ReturnRow('$this')
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
    protected function getGetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof AbstractOne2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractOne2OneMapping!');
        }

        $name = $fieldMapping->getName();
        $targetModel = $fieldMapping->getTargetModel();

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
                            new ReturnRow(new Name($targetModel))
                        ))
                    )
                )
            )
        );
    }
}
