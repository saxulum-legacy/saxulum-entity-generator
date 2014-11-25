<?php

namespace Saxulum\EntityGenerator\Type;

use PhpParser\Node;

interface TypeInterface
{
    /**
     * @return Node[]
     */
    public function getProperties();

    /**
     * @return Node[]
     */
    public function getMethods();
}