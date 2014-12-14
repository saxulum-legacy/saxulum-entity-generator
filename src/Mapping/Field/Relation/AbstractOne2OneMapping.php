<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Relation;

use Saxulum\ModelGenerator\Mapping\Field\AbstractFieldMapping;

abstract class AbstractOne2OneMapping extends AbstractFieldMapping
{
    /**
     * @var string
     */
    protected $targetClass;

    /**
     * @param string $name
     * @param string $targetClass
     */
    public function __construct($name, $targetClass)
    {
        parent::__construct($name);
        $this->targetClass = $targetClass;
    }

    /**
     * @return string
     */
    public function getTargetClass()
    {
        return $this->targetClass;
    }
}
