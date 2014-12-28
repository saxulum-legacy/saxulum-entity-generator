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
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneOwningSideMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;

class One2OneOwningSide extends AbstractOne2One
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2OneOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2OneOwningSideMapping!');
        }

        if (null === $inversedBy = $fieldMapping->getInversedBy()) {
            return array(
                $this->getUnidirectionalSetterMethodNode($fieldMapping),
                $this->getGetterMethodNode($fieldMapping->getName(), $fieldMapping->getTargetModel())
            );
        }

        return array(
            $this->getBidiretionalSetterMethodNode($fieldMapping, $inversedBy, 'set', 'set'),
            $this->getGetterMethodNode($fieldMapping->getName(), $fieldMapping->getTargetModel())
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getUnidirectionalSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2OneOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2OneOwningSideMapping!');
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
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2OneOwningSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2OneOwningSideMapping!');
        }

        if (null === $fieldMapping->getInversedBy()) {
            return array(
                new MethodCall(new Variable('builder'), 'addOwningOneToOne', array(
                    new Arg(new String($fieldMapping->getName())),
                    new Arg(new String($fieldMapping->getTargetModel()))
                ))
            );
        }

        return array(
            new MethodCall(new Variable('builder'), 'addOwningOneToOne', array(
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
        return 'one2one-owningside';
    }
}
