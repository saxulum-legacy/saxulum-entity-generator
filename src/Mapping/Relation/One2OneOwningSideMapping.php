<?php

namespace Saxulum\EntityGenerator\Mapping\Relation;

class One2OneOwningSideMapping extends AbstractOne2OneMapping
{
    /**
     * @var string|null
     */
    protected $inversedBy;

    /**
     * @param string      $name
     * @param string      $targetModel
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
        return 'one2one-owningside';
    }
}
