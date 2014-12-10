<?php

namespace Saxulum\ModelGenerator;

use Saxulum\ModelGenerator\Mapping\ModelMapping;

interface GeneratorInterface
{
    /**
     * @param ModelMapping $modelMapping
     * @return void
     */
    public function generate(ModelMapping $modelMapping);
}
