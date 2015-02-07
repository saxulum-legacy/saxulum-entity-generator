<?php

namespace Saxulum\ModelGenerator\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\Helper\StringUtil;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\AbstractRelationMapping;
use Saxulum\PhpDocGenerator\Documentor;
use Saxulum\PhpDocGenerator\ParamRow;
use Saxulum\PhpDocGenerator\ReturnRow;

abstract class Abstract2ManyRelationType extends AbstractRelationType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getConstructNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            new Assign(
                new PropertyFetch(new Variable('this'), $fieldMapping->getName()),
                new New_(new Name('\Doctrine\Common\Collections\ArrayCollection'))
            ),
        );
    }

    /**
     * @param  AbstractRelationMapping $fieldMapping
     * @param  string                  $relatedName
     * @param  string                  $methodPrefix
     * @param  string                  $relatedMethodPrefix
     * @param  string                  $collectionMethodName
     * @param  Arg                     $relatedArgument
     * @return Node
     */
    protected function getBidiretionalMethodNode(
        AbstractRelationMapping $fieldMapping,
        $relatedName,
        $methodPrefix,
        $relatedMethodPrefix,
        $collectionMethodName,
        $relatedArgument
    ) {
        $name = $fieldMapping->getName();
        $singularName = StringUtil::singularify($name);
        $singularRelatedName = StringUtil::singularify($relatedName);
        $targetModel = $fieldMapping->getTargetModel();

        return new ClassMethod($methodPrefix.ucfirst($singularName),
            array(
                'type' => 1,
                'params' => array(
                    new Param($singularName, null, new Name($targetModel)),
                    new Param('stopPropagation', new ConstFetch(new Name('false'))),
                ),
                'stmts' => array(
                    new MethodCall(
                        new PropertyFetch(new Variable('this'), $name),
                        $collectionMethodName,
                        array(
                            new Arg(new Variable($singularName)),
                        )
                    ),
                    new If_(
                        new BooleanNot(new Variable('stopPropagation')),
                        array(
                            'stmts' => array(
                                new MethodCall(
                                    new Variable($singularName),
                                    $relatedMethodPrefix.ucfirst($singularRelatedName),
                                    array(
                                        $relatedArgument,
                                        new Arg(new ConstFetch(new Name('true'))),
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
                            new ParamRow($targetModel, $singularName),
                            new ParamRow('bool', 'stopPropagation'),
                            new ReturnRow('$this'),
                        ))
                    ),
                ),
            )
        );
    }
}
