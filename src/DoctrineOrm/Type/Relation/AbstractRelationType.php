<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Relation;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;
use Saxulum\ModelGenerator\DoctrineOrm\TypeInterface;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;
use Saxulum\ModelGenerator\Mapping\Field\Relation\AbstractRelationMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ReturnRow;
use Saxulum\ModelGenerator\PhpDoc\VarRow;

abstract class AbstractRelationType implements TypeInterface
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getPropertyNodes(FieldMappingInterface $fieldMapping)
    {
        if (!$fieldMapping instanceof AbstractRelationMapping) {
            throw new \InvalidArgumentException('Field mapping has to be AbstractRelationMapping!');
        }

        return array(
            new Property(2,
                array(
                    new PropertyProperty($fieldMapping->getName())
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new VarRow($this->getVarString($fieldMapping))
                            ))
                        )
                    )
                )
            )
        );
    }

    /**
     * @param AbstractRelationMapping $fieldMapping
     * @return string
     */
    abstract protected function getVarString(AbstractRelationMapping $fieldMapping);

    /**
     * @param string $returnString
     * @return Node
     */
    protected function getGetterMethodNode($name, $returnString)
    {
        return new ClassMethod('get' . ucfirst($name),
            array(
                'type' => 1,
                'stmts' => array(
                    new Return_(new PropertyFetch(new Variable('this'), $name))
                )
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new ReturnRow($returnString)
                        ))
                    )
                )
            )
        );
    }
}
