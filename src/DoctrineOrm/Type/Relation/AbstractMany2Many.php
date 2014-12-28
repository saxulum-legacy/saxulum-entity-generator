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
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\AbstractMany2ManyMapping;
use Saxulum\ModelGenerator\Mapping\Field\Relation\AbstractRelationMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\Helper\StringUtil;

abstract class AbstractMany2Many extends Abstract2ManyRelationType
{
    /**
     * @param AbstractRelationMapping $fieldMapping
     * @return string
     */
    protected function getVarString(AbstractRelationMapping $fieldMapping)
    {
        return $fieldMapping->getTargetModel() . '[]|\Doctrine\Common\Collections\Collection';
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @param string $relatedName
     * @return Node
     */
    protected function getBidiretionalAddMethodNode(FieldMappingInterface $fieldMapping, $relatedName)
    {
        if (!$fieldMapping instanceof AbstractRelationMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractRelationMapping!');
        }

        return $this->getBidiretionalMethodNode(
            $fieldMapping,
            $relatedName,
            'add',
            'add',
            'add',
            new Arg(new Variable('this'))
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @param string $relatedName
     * @return Node
     */
    protected function getBidiretionalRemoveMethodNode(FieldMappingInterface $fieldMapping, $relatedName)
    {
        if (!$fieldMapping instanceof AbstractRelationMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractRelationMapping!');
        }

        return $this->getBidiretionalMethodNode(
            $fieldMapping,
            $relatedName,
            'remove',
            'remove',
            'removeElement',
            new Arg(new Variable('this'))
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
}
