<?php

namespace Saxulum\ModelGenerator\Type;

use PhpParser\Node;

interface TypeInterface
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getPropertyNodes($name);

    /**
     * @param string $name
     * @return Node[]
     */
    public function getMethodNodes($name);

    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMetadataNodes($name);

    /**
     * @return string
     */
    public function getPhpDocType();

    /**
     * @return string
     */
    public function getDoctrineOrmType();

    /**
     * @return string
     */
    public function getName();
}
