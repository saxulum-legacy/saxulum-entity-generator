<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Simple;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

class IdType extends AbstractType
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            $this->getGetterMethodNode($fieldMapping)
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            new MethodCall(
                new MethodCall(
                    new MethodCall(
                        new MethodCall(new Variable('builder'), 'createField', array(
                            new Arg(new String($fieldMapping->getName())),
                            new Arg(new String('integer'))
                        )),
                        'isPrimaryKey'
                    ),
                    'generatedValue'
                ),
                'build'
            )
        );
    }

    /**
     * @param FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'int';
    }

    /**
     * @return string
     */
    protected function getOrmType()
    {
        return 'id';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id';
    }
}
