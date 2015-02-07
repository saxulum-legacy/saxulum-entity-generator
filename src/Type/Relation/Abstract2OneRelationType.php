<?php

namespace Saxulum\EntityGenerator\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Relation\AbstractRelationMapping;
use Saxulum\PhpDocGenerator\Documentor;
use Saxulum\PhpDocGenerator\ParamRow;
use Saxulum\PhpDocGenerator\ReturnRow;

abstract class Abstract2OneRelationType extends AbstractRelationType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @param  string                $relatedName
     * @param  string                $relatedRemovePrefix
     * @param  string                $relatedAddPrefix
     * @return Node
     */
    protected function getBidiretionalSetterMethodNode(
        FieldMappingInterface $fieldMapping,
        $relatedName,
        $relatedRemovePrefix,
        $relatedAddPrefix
    ) {
        if (!$fieldMapping instanceof AbstractRelationMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractRelationMapping!');
        }

        $name = $fieldMapping->getName();
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod('set'.ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($name, new ConstFetch(new Name('null')), new Name($targetModel)),
                    new Param('stopPropagation', new ConstFetch(new Name('false'))),
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
                                                $relatedRemovePrefix.ucfirst($relatedName),
                                                array(
                                                    new Arg(new Variable('this')),
                                                    new Arg(new ConstFetch(new Name('true'))),
                                                )
                                            ),
                                        ),
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
                                                $relatedAddPrefix.ucfirst($relatedName),
                                                array(
                                                    new Arg(new Variable('this')),
                                                    new Arg(new ConstFetch(new Name('true'))),
                                                )
                                            ),
                                        ),
                                    )
                                ),
                            ),
                        )
                    ),
                    new Assign(
                        new PropertyFetch(new Variable('this'), $name),
                        new Variable($name)
                    ),
                    new Return_(new Variable('this')),
                ),
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new ParamRow($targetModel, $name),
                            new ParamRow('bool', 'stopPropagation'),
                            new ReturnRow('$this'),
                        ))
                    ),
                ),
            )
        );
    }
}
