<?php

namespace Saxulum\EntityGenerator\Type\Simple;

use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Simple\StringFieldMapping;

class StringType extends AbstractType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @param  array                 $items
     * @return array
     */
    protected function addOtherMetadataArrayItems(FieldMappingInterface $fieldMapping, array $items)
    {
        if (!$fieldMapping instanceof StringFieldMapping) {
            return $items;
        }

        if (null !== $length = $fieldMapping->getLength()) {
            $items[] = new ArrayItem(new LNumber($length), new String('length'));
        }

        return $items;
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return string
     */
    public function getPhpDocType(FieldMappingInterface $fieldMapping)
    {
        return 'string';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'string';
    }
}
