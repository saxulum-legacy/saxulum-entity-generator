<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Relation;

use Saxulum\ModelGenerator\Mapping\Field\AbstractFieldMapping;

class Many2OneMapping extends AbstractFieldMapping
{
    /**
     * @var string
     */
    protected $targetModel;

    /**
     * @var string|null
     */
    protected $inversedBy;

    /**
     * @param string $name
     * @param string $targetModel
     * @param string|null $inversedBy
     */
    public function __construct($name, $targetModel, $inversedBy = null)
    {
        parent::__construct($name);
        $this->targetModel = $targetModel;
        $this->inversedBy = $inversedBy;
    }

    /**
     * @return string
     */
    public function getTargetModel()
    {
        return $this->targetModel;
    }

    /**
     * @return null|string
     */
    public function getInversedBy()
    {
        return $this->inversedBy;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'many2one';
    }
}
