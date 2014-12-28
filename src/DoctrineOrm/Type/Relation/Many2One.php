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
use Saxulum\ModelGenerator\Mapping\Field\Relation\Many2OneMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;
use Saxulum\ModelGenerator\Helper\StringUtil;

class Many2One implements TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getPropertyNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2OneMapping!');
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
                                new VarRow($fieldMapping->getTargetModel())
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
        return array();
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2OneMapping!');
        }

        if (null === $inversedBy = $fieldMapping->getInversedBy()) {
            return array(
                $this->getUnidirectionalSetterMethodNode($fieldMapping),
                $this->getGetterMethodNode($fieldMapping)
            );
        }

        return array(
            $this->getBidiretionalSetterMethodNode($fieldMapping, $inversedBy),
            $this->getGetterMethodNode($fieldMapping)
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2OneMapping!');
        }
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getUnidirectionalSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2OneMapping!');
        }

        $name = $fieldMapping->getName();
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('set' . ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($fieldMapping->getName(), new ConstFetch(new Name('null')), new Name($targetModel))
                ),
                'stmts' => array(
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
    protected function getBidiretionalSetterMethodNode(FieldMappingInterface $fieldMapping, $relatedName)
    {
        if (!$fieldMapping instanceof Many2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2OneMapping!');
        }

        $name = $fieldMapping->getName();
        $singularRelatedName = StringUtil::singularify($relatedName);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('set' . ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($name, new ConstFetch(new Name('null')), new Name($targetModel)),
                    new Param('stopPropagation', new ConstFetch(new Name('false')))
                ),
                'stmts' => array(
                    new If_(
                        new BooleanNot(
                            new Variable('stopPropagation')
                        ),
                        array(
                            'stmts' => array(
                                new If_(
                                    new NotIdentical(
                                        new ConstFetch(new Name('null')),
                                        new PropertyFetch(new Variable('this'), $name)
                                    ),
                                    array(
                                        'stmts' => array(
                                            new MethodCall(
                                                new PropertyFetch(new Variable('this'), $name),
                                                'remove' . ucfirst($singularRelatedName),
                                                array(
                                                    new Arg(new Variable('this')),
                                                    new Arg(new ConstFetch(new Name('true')))
                                                )
                                            )
                                        )
                                    )
                                ),
                                new If_(
                                    new NotIdentical(
                                        new ConstFetch(new Name('null')),
                                        new Variable($name)
                                    ),
                                    array(
                                        'stmts' => array(
                                            new MethodCall(
                                                new Variable($name),
                                                'add' . ucfirst($singularRelatedName),
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
        if (!$fieldMapping instanceof Many2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2OneMapping!');
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
                            new ReturnRow($targetModel)
                        ))
                    )
                )
            )
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2OneMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2OneMapping!');
        }

        if (null === $fieldMapping->getInversedBy()) {
            return array(
                new MethodCall(new Variable('builder'), 'addManyToOne', array(
                    new Arg(new String($fieldMapping->getName())),
                    new Arg(new String($fieldMapping->getTargetModel()))
                ))
            );
        }

        return array(
            new MethodCall(new Variable('builder'), 'addManyToOne', array(
                new Arg(new String($fieldMapping->getName())),
                new Arg(new String($fieldMapping->getTargetModel())),
                new Arg(new String($fieldMapping->getInversedBy()))
            ))
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'many2one';
    }
}
