<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Relation;

use Saxulum\ModelGenerator\Mapping\Field\AbstractFieldMapping;

class One2ManyMapping extends AbstractFieldMapping
{
    /**
     * @var string
     */
    protected $targetModel;

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
        parent::__construct($name);
        $this->targetModel = $targetModel;
        $this->mappedBy = $mappedBy;
    }

    /**
     * @return string
     */
    public function getTargetModel()
    {
        return $this->targetModel;
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
