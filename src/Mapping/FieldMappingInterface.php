<?php

namespace Saxulum\ModelGenerator\Mapping;

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
