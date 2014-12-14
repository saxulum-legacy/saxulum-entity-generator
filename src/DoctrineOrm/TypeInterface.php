<?php

namespace Saxulum\ModelGenerator\DoctrineOrm;

use PhpParser\Node;
use Saxulum\ModelGenerator\TypeInterface as BaseTypeInterface;

interface TypeInterface extends BaseTypeInterface
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmPropertyNodes($name);

    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMethodNodes($name);

    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMetadataNodes($name);
}
