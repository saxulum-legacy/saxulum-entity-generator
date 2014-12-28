<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\Many2ManyOwningSideMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Symfony\Component\PropertyAccess\StringUtil;

class Many2ManyOwningSide extends AbstractMany2Many
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyOwningSideMapping!');
        }

        if (null === $inversedBy = $fieldMapping->getInversedBy()) {
            return array(
                $this->getUnidirectionalAddMethodNode($fieldMapping),
                $this->getUnidirectionalRemoveMethodNode($fieldMapping),
                $this->getUnidirectionalSetterMethodNode($fieldMapping),
                $this->getGetterMethodNode($fieldMapping)
            );
        }

        return array(
            $this->getBidiretionalAddMethodNode($fieldMapping, $inversedBy),
            $this->getBidiretionalRemoveMethodNode($fieldMapping, $inversedBy),
            $this->getBidiretionalSetterMethodNode($fieldMapping, $inversedBy),
            $this->getGetterMethodNode($fieldMapping)
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getUnidirectionalAddMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyOwningSideMapping!');
        }

        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('add' . ucfirst($singularName),
            array(
                'type' => 1,
                'params' => array(
                    new Param($singularName, null, new Name($targetModel)),
                ),
                'stmts' => array(
                    new MethodCall(
                        new PropertyFetch(new Variable('this'), $name),
                        'add',
                        array(
                            new Arg(new Variable($singularName))
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
    protected function getUnidirectionalRemoveMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyOwningSideMapping!');
        }

        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('remove' . ucfirst($singularName),
            array(
                'type' => 1,
                'params' => array(
                    new Param($singularName, null, new Name($targetModel)),
                ),
                'stmts' => array(
                    new MethodCall(
                        new PropertyFetch(new Variable('this'), $name),
                        'removeElement',
                        array(
                            new Arg(new Variable($singularName))
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
    protected function getUnidirectionalSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyOwningSideMapping!');
        }

        $name = $fieldMapping->getName();
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('set' . ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($fieldMapping->getName())
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
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyOwningSideMapping!');
        }

        if (null === $fieldMapping->getInversedBy()) {
            return array(
                new MethodCall(new Variable('builder'), 'addOwningManyToMany', array(
                    new Arg(new String($fieldMapping->getName())),
                    new Arg(new String($fieldMapping->getTargetModel()))
                ))
            );
        }

        return array(
            new MethodCall(new Variable('builder'), 'addOwningManyToMany', array(
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
        return 'many2many-owningside';
    }
}
