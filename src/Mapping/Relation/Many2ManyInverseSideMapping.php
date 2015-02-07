<?php

namespace Saxulum\ModelGenerator\Mapping\Relation;

class Many2ManyInverseSideMapping extends AbstractMany2ManyMapping
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
        return 'many2many-inverseside';
    }
}
