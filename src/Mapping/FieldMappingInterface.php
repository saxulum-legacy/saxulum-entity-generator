<?php

namespace Saxulum\EntityGenerator\Mapping;

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
