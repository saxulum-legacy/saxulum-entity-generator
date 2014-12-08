<?php

namespace Saxulum\ModelGenerator\Type;

use PhpParser\Node;

interface TypeInterface
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getProperty($name);

    /**
     * @param string $name
     * @return Node[]
     */
    public function getMethods($name);

    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMetadata($name);

    /**
     * @return string
     */
    public function getName();
}
