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
     * @param string $targetModel
     * @param string $mappedBy
     */
    public function __construct($name, $targetModel, $mappedBy)
    {
        parent::__construct($name, $targetModel);
        $this->mappedBy = $mappedBy;
    }

    /**
     * @return null|string
     */
    public function getMappedBy()
    {
        return $this->mappedBy;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'one2one-inverseside';
    }
}
