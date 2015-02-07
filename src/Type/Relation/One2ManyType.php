<?php

namespace Saxulum\EntityGenerator\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Return_;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Relation\AbstractRelationMapping;
use Saxulum\EntityGenerator\Mapping\Relation\One2ManyMapping;
use Saxulum\PhpDocGenerator\Documentor;
use Saxulum\PhpDocGenerator\ParamRow;
use Saxulum\PhpDocGenerator\ReturnRow;
use Saxulum\EntityGenerator\Helper\StringUtil;

class One2ManyType extends Abstract2ManyRelationType
{
    /**
     * @param  AbstractRelationMapping $fieldMapping
     * @return string
     */
    protected function getVarString(AbstractRelationMapping $fieldMapping)
    {
        return $fieldMapping->getTargetModel().'[]|\Doctrine\Common\Collections\Collection';
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        return array(
            $this->getAddMethodNode($fieldMapping),
            $this->getRemoveMethodNode($fieldMapping),
            $this->getSetterMethodNode($fieldMapping),
            $this->getGetterMethodNode(
                $fieldMapping->getName(),
                $fieldMapping->getTargetModel().'[]|\Doctrine\Common\Collections\Collection'
            ),
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getAddMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        return $this->getBidiretionalMethodNode(
            $fieldMapping,
            $fieldMapping->getMappedBy(),
            'add',
            'set',
            'add',
            new Arg(new Variable('this'))
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getRemoveMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        return $this->getBidiretionalMethodNode(
            $fieldMapping,
            $fieldMapping->getMappedBy(),
            'remove',
            'set',
            'removeElement',
            new Arg(new ConstFetch(new Name('null')))
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('set'.ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($name),
                ),
                'stmts' => array(
                    new Foreach_(
                        new PropertyFetch(new Variable('this'), $name),
                        new Variable($singularName),
                        array(
                            'stmts' => array(
                                new MethodCall(
                                    new Variable('this'),
                                    'remove'.ucfirst($singularName),
                                    array(
                                        new Arg(new Variable($singularName)),
                                    )
                                ),
                            ),
                        )
                    ),
                    new Foreach_(
                        new Variable($name),
                        new Variable($singularName),
                        array(
                            'stmts' => array(
                                new MethodCall(
                                    new Variable('this'),
                                    'add'.ucfirst($singularName),
                                    array(
                                        new Arg(new Variable($singularName)),
                                    )
                                ),
                            ),
                        )
                    ),
                    new Return_(new Variable('this')),
                ),
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new ParamRow($targetModel.'[]|\Doctrine\Common\Collections\Collection', $name),
                            new ReturnRow('$this'),
                        ))
                    ),
                ),
            )
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2ManyMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2ManyMapping!');
        }

        return array(
            new MethodCall(new Variable('builder'), 'addOneToMany', array(
                new Arg(new String($fieldMapping->getName())),
                new Arg(new String($fieldMapping->getTargetModel())),
                new Arg(new String($fieldMapping->getMappedBy())),
            )),
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'one2many';
    }
}
