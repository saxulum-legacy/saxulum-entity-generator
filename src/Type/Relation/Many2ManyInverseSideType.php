<?php

namespace Saxulum\EntityGenerator\Type\Relation;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Relation\Many2ManyInverseSideMapping;

class Many2ManyInverseSideType extends AbstractMany2ManyType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyInverseSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyInverseSideMapping!');
        }

        return array(
            $this->getBidiretionalAddMethodNode($fieldMapping, $fieldMapping->getMappedBy()),
            $this->getBidiretionalRemoveMethodNode($fieldMapping, $fieldMapping->getMappedBy()),
            $this->getBidiretionalSetterMethodNode($fieldMapping),
            $this->getGetterMethodNode(
                $fieldMapping->getName(),
                $fieldMapping->getTargetModel().'[]|\Doctrine\Common\Collections\Collection'
            ),
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyInverseSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyInverseSideMapping!');
        }

        return array(
            new MethodCall(new Variable('builder'), 'addInverseManyToMany', array(
                new Arg(new String_($fieldMapping->getName())),
                new Arg(new String_($fieldMapping->getTargetModel())),
                new Arg(new String_($fieldMapping->getMappedBy())),
            )),
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'many2many-inverseside';
    }
}
