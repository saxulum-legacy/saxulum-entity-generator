<?php

namespace Saxulum\EntityGenerator\Mapping\Simple;

use Saxulum\EntityGenerator\Mapping\AbstractFieldMapping;

class DecimalFieldMapping extends AbstractFieldMapping
{
    /**
     * @var int
     */
    protected $precision;

    /**
     * @var int
     */
    protected $scale;

    /**
     * @param string      $name
     * @param int         $precision
     * @param int         $scale
     * @param bool|null   $unique
     * @param bool|null   $nullable
     * @param string|null $columnName
     * @param string|null $columnDefinition
     * @param array|null  $options
     */
    public function __construct(
        $name,
        $precision = null,
        $scale = null,
        $unique = null,
        $nullable = null,
        $columnName = null,
        $columnDefinition = null,
        array $options = null
    ) {
        parent::__construct($name, $unique, $nullable, $columnName, $columnDefinition, $options);

        $this->precision = $precision;
        $this->scale = $scale;
    }

    /**
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @return int
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'decimal';
    }
}
