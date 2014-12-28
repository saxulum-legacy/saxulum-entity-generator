<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Relation;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\Many2ManyInverseSideMapping;

class Many2ManyInverseSide extends AbstractMany2Many
{
    /**
     * @param FieldMappingInterface $fieldMapping
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
            $this->getBidiretionalSetterMethodNode($fieldMapping, $fieldMapping->getMappedBy()),
            $this->getGetterMethodNode($fieldMapping)
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof Many2ManyInverseSideMapping) {
            throw new \InvalidArgumentException('Field mapping has to be Many2ManyInverseSideMapping!');
        }

        return array(
            new MethodCall(new Variable('builder'), 'addInverseManyToMany', array(
                new Arg(new String($fieldMapping->getName())),
                new Arg(new String($fieldMapping->getTargetModel())),
                new Arg(new String($fieldMapping->getMappedBy()))
            ))
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
