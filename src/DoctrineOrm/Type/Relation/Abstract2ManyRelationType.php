<?php

namespace Saxulum\ModelGenerator\DoctrineOrm\Type\Relation;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use Saxulum\ModelGenerator\Mapping\Field\FieldMappingInterface;

abstract class Abstract2ManyRelationType extends AbstractRelationType
{
    /**
     * @param FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getConstructNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            new Assign(
                new PropertyFetch(new Variable('this'), $fieldMapping->getName()),
                new New_(new Name('\Doctrine\Common\Collections\ArrayCollection'))
            )
        );
    }
}
