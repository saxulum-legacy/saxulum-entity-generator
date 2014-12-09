<?php

namespace Saxulum\ModelGenerator;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\Mapping\ModelMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;
use Saxulum\ModelGenerator\Type\TypeInterface;

class Generator
{
    const CLASS_ORM_METADATA = '\Doctrine\ORM\Mapping\ClassMetadata';
    const CLASS_ORM_METADATA_BUILDER = '\Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder';

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

        foreach ($types as $type) {
            if (!$type instanceof TypeInterface) {
                throw new \InvalidArgumentException("Type is not an instance of TypeInterface!");
            }

            $this->types[$type->getName()] = $type;
        }
    }

    public function generateEntity(ModelMapping $modelMapping)
    {
        $nodes = array();
        $nodes = array_merge($nodes, $this->generatePropertyNodes($modelMapping));
        $nodes = array_merge($nodes, $this->generateMethodNodes($modelMapping));
        $nodes = array_merge($nodes, $this->generateDoctrineOrmMetadataNodes($modelMapping));
        $nodes = array(new Class_($modelMapping->getName(), array('stmts' => $nodes)));

        echo $this->phpGenerator->prettyPrint($nodes);
    }

    /**
     * @param ModelMapping $modelMapping
     * @return Node[]
     * @throws \Exception
     */
    protected function generatePropertyNodes(ModelMapping $modelMapping)
    {
        return $this->generateNodes($modelMapping, 'getPropertyNodes');
    }

    /**
     * @param ModelMapping $modelMapping
     * @return Node[]
     * @throws \Exception
     */
    protected function generateMethodNodes(ModelMapping $modelMapping)
    {
        return $this->generateNodes($modelMapping, 'getMethodNodes');
    }

    /**
     * @param ModelMapping $modelMapping
     * @return Node[]
     * @throws \Exception
     */
    protected function generateDoctrineOrmMetadataNodes(ModelMapping $modelMapping)
    {
        return array(
            new ClassMethod('loadMetadata',
                array(
                    'type' => 9,
                    'params' => array(
                        new Param('metadata', null, new Name(static::CLASS_ORM_METADATA))
                    ),
                    'stmts' => array_merge(
                        array(
                            new Assign(new Variable('builder'), new New_(new Name(static::CLASS_ORM_METADATA_BUILDER), array(
                                new Arg(new Variable('metadata'))
                            )))
                        ),
                        $this->generateNodes($modelMapping, 'getDoctrineOrmMetadataNodes')
                    )
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new ParamRow(static::CLASS_ORM_METADATA, 'metadata')
                            ))
                        )
                    )
                )
            )
        );
    }

    /**
     * @param ModelMapping $modelMapping
     * @param  string            $getterName
     * @return Node[]
     * @throws \Exception
     */
    protected function generateNodes(ModelMapping $modelMapping, $getterName)
    {
        $fieldNodes = array();
        foreach ($modelMapping->getFieldMappings() as $fieldMapping) {
            $type = $this->getType($fieldMapping->getType());
            if (null === $type) {
                throw new \Exception("Unknown type: {$fieldMapping->getType()}!");
            }
            if (!is_callable(array($type, $getterName))) {
                throw new \Exception("Can't call {$fieldMapping->getType()} method {$getterName}!");
            }

            $fieldNodes = array_merge($fieldNodes, $type->$getterName($fieldMapping->getName()));
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
