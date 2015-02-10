<?php

namespace Saxulum\EntityGenerator\Mapping\Simple;

use Saxulum\EntityGenerator\Mapping\AbstractFieldMapping;

class StringFieldMapping extends AbstractFieldMapping
{
    /**
     * @var int
     */
    protected $length;

    /**
     * @param string      $name
     * @param int|null    $length
     * @param bool|null   $unique
     * @param bool|null   $nullable
     * @param string|null $columnName
     * @param string|null $columnDefinition
     * @param array|null  $options
     */
    public function __construct(
        $name,
        $length = null,
        $unique = null,
        $nullable = null,
        $columnName = null,
        $columnDefinition = null,
        array $options = null
    ) {
        parent::__construct($name, $unique, $nullable, $columnName, $columnDefinition, $options);

        $this->length = $length;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'string';
    }
}
