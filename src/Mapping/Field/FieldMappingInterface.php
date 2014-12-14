<?php

namespace Saxulum\ModelGenerator\Mapping\Field;

interface FieldMappingInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getType();
}
