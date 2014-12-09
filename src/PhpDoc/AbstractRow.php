<?php

namespace Saxulum\ModelGenerator\PhpDoc;

abstract class AbstractRow
{
    /**
     * @var string[]
     */
    protected $parts;

    /**
     * @param string|null $part
     */
    protected function addPart($part)
    {
        if (null !== $part) {
            $this->parts[] = $part;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = '@' . $this->getName();
        foreach ($this->parts as $part) {
            $string .= ' ' . $part;
        }

        return $string;
    }

    /**
     * @return string
     */
    abstract public function getName();
}
