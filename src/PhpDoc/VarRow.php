<?php

namespace Saxulum\ModelGenerator\PhpDoc;

class VarRow extends AbstractRow
{
    /**
     * @param string $type
     * @param string $elementName
     * @param string $description
     */
    public function __construct($type, $elementName = null, $description = null)
    {
        $this->addPart($type);
        $this->addPart($elementName);
        $this->addPart($description);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'var';
    }
}