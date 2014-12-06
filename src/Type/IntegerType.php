<?php

namespace Saxulum\EntityGenerator\Type;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String;

class IntegerType extends AbstractSimpleType
{
    /**
     * @param string $name
     * @return Node[]
     */
    public function getDoctrineOrmMetadata($name)
    {
        return array(
            new MethodCall(new Variable('builder'), 'addField', array(
                new Arg(new String($name)),
                new Arg(new String('integer'))
            ))
        );
    }
}
