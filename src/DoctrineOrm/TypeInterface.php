<?php

namespace Saxulum\ModelGenerator\DoctrineOrm;

use PhpParser\Node;

interface TypeInterface
{
    /**
     * @param string $name
     * @return Node
     */
    public function getPropertyNode($name);

    /**
     * @param string $name
     * @return Node[]
     */
    public function getMethodsNodes($name);

    /**
     * @param string $name
     * @return Node
     */
    public function getMetadataNode($name);

    /**
     * @return string
     */
    public function getName();
}
