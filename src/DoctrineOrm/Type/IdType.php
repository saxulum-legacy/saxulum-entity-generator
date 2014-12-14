<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\DoctrineOrm\TypeInterface;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;

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
     * @return Node
     */
    public function getMetadataNode(FieldMappingInterface $fieldMapping)
    {
        return new MethodCall(
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
