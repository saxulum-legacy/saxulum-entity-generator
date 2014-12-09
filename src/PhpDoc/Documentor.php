<?php

namespace Saxulum\ModelGenerator\PhpDoc;

class Documentor
{
    /**
     * @var AbstractRow[]
     */
    protected $rows;

    /**
     * @param array $rows
     */
    public function __construct(array $rows)
    {
        foreach ($rows as $row) {
            if (!$row instanceof AbstractRow) {
                throw new \InvalidArgumentException('Rows have to extend AbstractRow!');
            }

            $this->rows[] = $row;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = '/**' . PHP_EOL;
        foreach ($this->rows as $row) {
            $string .= ' * ' . (string) $row . PHP_EOL;
        }
        $string .= ' */';

        return $string;
    }
}
