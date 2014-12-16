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
use PhpParser\Node\Expr\New_;
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
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2ManyMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneOwningSideMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;
use Symfony\Component\PropertyAccess\StringUtil;

class One2Many implements TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getPropertyNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        return new Property(2,
            array(
                new PropertyProperty($fieldMapping->getName())
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new VarRow($fieldMapping->getTargetModel() . '[]|\Doctrine\Common\Collections\Collection')
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
        return new Assign(
            new PropertyFetch(new Variable('this')),
            new New_(new Name('\Doctrine\Common\Collections\ArrayCollection'))
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $mappedBy = $fieldMapping->getMappedBy();

        return array(
            new ClassMethod('add' . ucfirst($singularName),
                array(
                    'type' => 1,
                    'params' => array(
                        new Param($singularName, new ConstFetch(new Name('null')), new Name($fieldMapping->getTargetModel())),
                        new Param('stopPropagation', new ConstFetch(new Name('false')))
                    ),
                    'stmts' => array(
                        new MethodCall(
                            new PropertyFetch(new Variable('this'), $name),
                            'add',
                            array(
                                new Arg(new Variable($singularName))
                            )
                        ),
                        new Node\Stmt\If_(
                            new Expr\BooleanNot(
                                new Variable('stopPropagation')
                            ),
                            array(
                                'stmts' => array(
                                    new MethodCall(
                                        new Variable($singularName),
                                        'set' . ucfirst($mappedBy),
                                        array(
                                            new Arg(new Variable('this')),
                                            new Arg(new ConstFetch(new Name('true')))
                                        )
                                    )
                                ),
                            )
                        ),
                        new Return_(new Variable('this'))
                    )
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new ParamRow($fieldMapping->getTargetModel(), $singularName),
                                new ParamRow('bool', 'stopPropagation'),
                                new ReturnRow('$this')
                            ))
                        )
                    )
                )
            ),
            new ClassMethod('remove' . ucfirst($singularName),
                array(
                    'type' => 1,
                    'params' => array(
                        new Param($singularName, new ConstFetch(new Name('null')), new Name($fieldMapping->getTargetModel())),
                        new Param('stopPropagation', new ConstFetch(new Name('false')))
                    ),
                    'stmts' => array(
                        new MethodCall(
                            new PropertyFetch(new Variable('this'), $name),
                            'removeElement',
                            array(
                                new Arg(new Variable($singularName))
                            )
                        ),
                        new Node\Stmt\If_(
                            new Expr\BooleanNot(
                                new Variable('stopPropagation')
                            ),
                            array(
                                'stmts' => array(
                                    new MethodCall(
                                        new Variable($singularName),
                                        'set' . ucfirst($mappedBy),
                                        array(
                                            new Arg(new ConstFetch(new Name('null'))),
                                            new Arg(new ConstFetch(new Name('true')))
                                        )
                                    )
                                ),
                            )
                        ),
                        new Return_(new Variable('this'))
                    )
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new ParamRow($fieldMapping->getTargetModel(), $singularName),
                                new ParamRow('bool', 'stopPropagation'),
                                new ReturnRow('$this')
                            ))
                        )
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
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        return new MethodCall(new Variable('builder'), 'addOneToMany', array(
            new Arg(new String($fieldMapping->getName())),
            new Arg(new String($fieldMapping->getTargetModel())),
            new Arg(new String($fieldMapping->getMappedBy()))
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'one2many';
    }
}