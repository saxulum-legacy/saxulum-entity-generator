<?php

namespace Saxulum\ModelGenerator;

use Saxulum\ModelGenerator\Mapping\ModelMapping;

interface GeneratorInterface
{
    /**
     * @param ModelMapping $modelMapping
     * @param string $namespace
     * @param string $path
     * @param bool $override
     * @return void
     */
    public function generate(ModelMapping $modelMapping, $namespace, $path, $override = false);
}
