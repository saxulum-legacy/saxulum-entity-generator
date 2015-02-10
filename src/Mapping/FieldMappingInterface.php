<?php

namespace Saxulum\EntityGenerator\Mapping;

interface FieldMappingInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return boolean
     */
    public function isUnique();

    /**
     * @return boolean
     */
    public function isNullable();

    /**
     * @return null|string
     */
    public function getColumnName();

    /**
     * @return null|string
     */
    public function getColumnDefinition();

    /**
     * @return null|array
     */
    public function getOptions();

    /**
     * @return string
     */
    public function getType();
}
