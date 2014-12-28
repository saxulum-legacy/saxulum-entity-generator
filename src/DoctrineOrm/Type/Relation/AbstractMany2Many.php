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
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\DoctrineOrm\TypeInterface;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\AbstractMany2ManyMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;
use Saxulum\ModelGenerator\Helper\StringUtil;

abstract class AbstractMany2Many implements TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getPropertyNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof AbstractMany2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractMany2ManyMapping!');
        }

        return array(
            new Property(2,
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
            )
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getConstructNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            new Assign(
                new PropertyFetch(new Variable('this'), $fieldMapping->getName()),
                new New_(new Name('\Doctrine\Common\Collections\ArrayCollection'))
            )
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @param string $relatedName
     * @return Node
     */
    protected function getBidiretionalAddMethodNode(FieldMappingInterface $fieldMapping, $relatedName)
    {
        if (!$fieldMapping instanceof AbstractMany2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractMany2ManyMapping!');
        }

        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $singularRelatedName = StringUtil::singularify($relatedName);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('add' . ucfirst($singularName),
            array(
                'type' => 1,
                'params' => array(
                    new Param($singularName, null, new Name($targetModel)),
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
                    new If_(
                        new BooleanNot(new Variable('stopPropagation')),
                        array(
                            'stmts' => array(
                                new MethodCall(
                                    new Variable($singularName),
                                    'add' . ucfirst($singularRelatedName),
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
                            new ParamRow($targetModel, $singularName),
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
     * @param string $relatedName
     * @return Node
     */
    protected function getBidiretionalRemoveMethodNode(FieldMappingInterface $fieldMapping, $relatedName)
    {
        if (!$fieldMapping instanceof AbstractMany2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractMany2ManyMapping!');
        }

        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $singularRelatedName = StringUtil::singularify($relatedName);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('remove' . ucfirst($singularName),
            array(
                'type' => 1,
                'params' => array(
                    new Param($singularName, null, new Name($targetModel)),
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
                    new If_(
                        new BooleanNot(new Variable('stopPropagation')),
                        array(
                            'stmts' => array(
                                new MethodCall(
                                    new Variable($singularName),
                                    'remove' . ucfirst($singularRelatedName),
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
                            new ParamRow($targetModel, $singularName),
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
    protected function getBidiretionalSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof AbstractMany2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractMany2ManyMapping!');
        }

        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('set' . ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($name)
                ),
                'stmts' => array(
                    new Foreach_(
                        new PropertyFetch(new Variable('this'), $name),
                        new Variable($singularName),
                        array(
                            'stmts' => array(
                                new MethodCall(
                                    new Variable('this'),
                                    'remove' . ucfirst($singularName),
                                    array(
                                        new Arg(new Variable($singularName))
                                    )
                                )
                            )
                        )
                    ),
                    new Foreach_(
                        new Variable($name),
                        new Variable($singularName),
                        array(
                            'stmts' => array(
                                new MethodCall(
                                    new Variable('this'),
                                    'add' . ucfirst($singularName),
                                    array(
                                        new Arg(new Variable($singularName))
                                    )
                                )
                            )
                        )
                    ),
                    new Return_(new Variable('this'))
                )
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new ParamRow($targetModel . '[]|\Doctrine\Common\Collections\Collection', $name),
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
        if (!$fieldMapping instanceof AbstractMany2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractMany2ManyMapping!');
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
                            new ReturnRow($targetModel . '[]|\Doctrine\Common\Collections\Collection')
                        ))
                    )
                )
            )
        );
    }
}
