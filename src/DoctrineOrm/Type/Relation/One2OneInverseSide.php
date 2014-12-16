<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Relation;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\One2OneInverseSideMapping;

class One2OneInverseSide extends AbstractOne2One
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2OneInverseSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2OneInverseSideMapping!');
        }

        return array(
            $this->getBidiretionalSetterMethodNode($fieldMapping, $fieldMapping->getMappedBy()),
            $this->getGetterMethodNode($fieldMapping)
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node
     */
    public function getMetadataNode(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof One2OneInverseSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be One2OneInverseSideMapping!');
        }

        return new MethodCall(new Variable('builder'), 'addInverseOneToOne', array(
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
        return 'one2one-inverseside';
    }
}
