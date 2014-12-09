<?php

namespace Saxulum\ModelGenerator\PhpDoc;

class ParamRow extends AbstractRow
{
    /**
     * @param string $type
     * @param string $name
     * @param string $description
     */
    public function __construct($type, $name, $description = null)
    {
        $this->addPart($type);
        $this->addPart('$' . $name);
        $this->addPart($description);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'param';
    }
}