<?php

namespace Saxulum\EntityGenerator\Type\Simple;

use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\EntityGenerator\Mapping\Simple\DecimalFieldMapping;

class DecimalType extends AbstractType
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @param  array                 $items
     * @return array
     */
    protected function addOtherMetadataArrayItems(FieldMappingInterface $fieldMapping, array $items)
    {
        if (!$fieldMapping instanceof DecimalFieldMapping) {
            return $items;
        }

        if (null !== $precision = $fieldMapping->getPrecision()) {
            $items[] = new ArrayItem(new LNumber($precision), new String_('precision'));
        }

        if (null !== $scale = $fieldMapping->getScale()) {
            $items[] = new ArrayItem(new LNumber($scale), new String_('scale'));
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
        return 'decimal';
    }
}
