<?php

namespace Saxulum\EntityGenerator\Mapping\Relation;

class One2ManyMapping extends AbstractRelationMapping
{
    /**
     * @var string
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
     * @return string
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
        return 'one2many';
    }
}
