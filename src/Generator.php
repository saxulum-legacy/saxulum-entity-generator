<?php

namespace Saxulum\ModelGenerator;

use PhpParser\Node\Stmt\Class_;
use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\Mapping\ModelMapping;
use Saxulum\ModelGenerator\Type\TypeInterface;

class Generator
{
    /**
     * @var PhpGenerator
     */
    protected $phpGenerator;

    /**
     * @var TypeInterface[]
     */
    protected $types;

    /**
     * @param PhpGenerator $phpGenerator
     * @param TypeInterface[] $types
     */
    public function __construct(PhpGenerator $phpGenerator, array $types)
    {
        $this->phpGenerator = $phpGenerator;

        foreach($types as $type) {
            if(!$type instanceof TypeInterface) {
                throw new \InvalidArgumentException("Type is not an instance of TypeInterface!");
            }

            $this->types[$type->getName()] = $type;
        }
    }

    public function generateModel(ModelMapping $modelMapping)
    {
        $subNodes = array();
        $subNodes = array_merge($subNodes, $this->generatePropertyNodes($modelMapping));
        $subNodes = array_merge($subNodes, $this->generateMethodNodes($modelMapping));

        $model = new Class_($modelMapping->getName(), array('stmts' => $subNodes));

        echo $this->phpGenerator->prettyPrint(array($model));
    }

    /**
     * @param ModelMapping $modelMapping
     * @return array
     * @throws \Exception
     */
    protected function generatePropertyNodes(ModelMapping $modelMapping)
    {
        $fieldNodes = array();
        foreach($modelMapping->getFieldMappings() as $fieldMapping) {
            $type = $this->getType($fieldMapping->getType());
            if(null === $type) {
                throw new \Exception("Unknown type: {$fieldMapping->getType()}!");
            }

            $fieldNodes = array_merge($fieldNodes, $type->getProperty($fieldMapping->getName()));
        }

        return $fieldNodes;
    }

    /**
     * @param ModelMapping $modelMapping
     * @return array
     * @throws \Exception
     */
    protected function generateMethodNodes(ModelMapping $modelMapping)
    {
        $fieldNodes = array();
        foreach($modelMapping->getFieldMappings() as $fieldMapping) {
            $type = $this->getType($fieldMapping->getType());
            if(null === $type) {
                throw new \Exception("Unknown type: {$fieldMapping->getType()}!");
            }

            $fieldNodes = array_merge($fieldNodes, $type->getMethods($fieldMapping->getName()));
        }

        return $fieldNodes;
    }

    /**
     * @param $type
     * @return null|TypeInterface
     */
    protected function getType($type)
    {
        return isset($this->types[$type]) ? $this->types[$type] : null;
    }
}