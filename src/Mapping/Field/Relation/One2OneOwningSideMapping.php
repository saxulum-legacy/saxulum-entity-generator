<?php

namespace Saxulum\ModelGenerator\Mapping\Field\Relation;

class One2OneOwningSideMapping extends AbstractOne2OneMapping
{
    /**
     * @var string|null
     */
    protected $inversedBy;

    /**
     * @param string $name
     * @param string $targetClass
     * @param string|null $inversedBy
     */
    public function __construct($name, $targetClass, $inversedBy = null)
    {
        parent::__construct($name, $targetClass);
        $this->inversedBy = $inversedBy;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'one2one-owningside';
    }

    /**
     * @return null|string
     */
    public function getInversedBy()
    {
        return $this->inversedBy;
    }
}
