<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Relation;

class One2OneInverseSideMapping extends AbstractOne2OneMapping
{
    /**
     * @var string|null
     */
    protected $mappedBy;

    /**
     * @param string $name
     * @param string $targetClass
     * @param string $mappedBy
     */
    public function __construct($name, $targetClass, $mappedBy)
    {
        parent::__construct($name, $targetClass);
        $this->mappedBy = $mappedBy;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'one2one-inverseside';
    }

    /**
     * @return null|string
     */
    public function getMappedBy()
    {
        return $this->mappedBy;
    }
}
