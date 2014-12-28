<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Relation;

class Many2ManyOwningSideMapping extends AbstractMany2ManyMapping
{
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
        parent::__construct($name, $targetModel);
        $this->inversedBy = $inversedBy;
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
        return 'many2many-owningside';
    }
}
