<?php

namespace Saxulum\EntityGenerator\Type;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;

class TextType implements TypeInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return Expr[]
     */
    public function getProperties()
    {
        return array(
            new Property(2, array(
                new PropertyProperty($this->name)
            )),
        );
    }

    /**
     * @return Expr[]
     */
    public function getMethods()
    {
        return array(
            new ClassMethod('set' . ucfirst($this->name), array(
                'type' => 1,
                'params' => array(
                    new Param($this->name)
                ),
                'stmts' => array(
                    new Assign(
                        new PropertyFetch(new Variable('this'), $this->name),
                        new Variable($this->name)
                    )
                )
            )),
            new ClassMethod('get' . ucfirst($this->name), array(
                'type' => 1,
                'stmts' => array(
                    new Return_(new PropertyFetch(new Variable('this'), $this->name))
                )
            ))
        );
    }
}