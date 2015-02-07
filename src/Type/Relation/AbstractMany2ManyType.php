<?php

namespace Saxulum\EntityGenerator\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Return_;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Relation\AbstractMany2ManyMapping;
use Saxulum\EntityGenerator\Mapping\Relation\AbstractRelationMapping;
use Saxulum\PhpDocGenerator\Documentor;
use Saxulum\PhpDocGenerator\ParamRow;
use Saxulum\PhpDocGenerator\ReturnRow;
use Saxulum\EntityGenerator\Helper\StringUtil;

abstract class AbstractMany2ManyType extends Abstract2ManyRelationType
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
     * @param  string                $relatedName
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
     * @param  FieldMappingInterface $fieldMapping
     * @param  string                $relatedName
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
     * @param  FieldMappingInterface $fieldMapping
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
}
