<?php

namespace Saxulum\EntityGenerator\Type\Simple;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;

class IdType extends AbstractType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            $this->getGetterMethodNode($fieldMapping),
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            new MethodCall(
                new MethodCall(
                    new MethodCall(
                        new MethodCall(new Variable('builder'), 'createField', array(
                            new Arg(new String_($fieldMapping->getName())),
                            new Arg(new String_('integer')),
                        )),
                        'isPrimaryKey'
                    ),
                    'generatedValue'
                ),
                'build'
            ),
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'int';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id';
    }
}
