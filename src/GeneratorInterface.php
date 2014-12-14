<?php

namespace Saxulum\ModelGenerator;

use Saxulum\ModelGenerator\Mapping\ModelMapping;

interface GeneratorInterface
{
    /**
     * @param ModelMapping $modelMapping
     * @param bool $override
     * @return void
     */
    public function generate(ModelMapping $modelMapping, $override = false);
}
