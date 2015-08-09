<?php

namespace Saxulum\EntityGenerator\Mapping;

abstract class AbstractFieldMapping implements FieldMappingInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool|null
     */
    protected $unique;

    /**
     * @var bool|null
     */
    protected $nullable;

    /**
     * @var string|null
     */
    protected $columnName;

    /**
     * @var string|null
     */
    protected $columnDefinition;

    /**
     * @var null|array
     */
    protected $options;

    /**
     * @param string $name
     * @param bool|null   $unique
     * @param bool|null   $nullable
     * @param string|null $columnName
     * @param string|null $columnDefinition
     * @param array|null       $options
     */
    public function __construct($name, $unique = null, $nullable = null, $columnName = null,$columnDefinition = null, array $options = null)
    {
        $this->name = $name;

        $this->unique = $unique;
        $this->nullable = $nullable;
        $this->columnName = $columnName;
        $this->columnDefinition = $columnDefinition;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * @return boolean
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * @return null|string
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * @return null|string
     */
    public function getColumnDefinition()
    {
        return $this->columnDefinition;
    }

    /**
     * @return null|array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
