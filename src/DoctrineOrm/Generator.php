<?php

namespace Saxulum\ModelGenerator\DoctrineOrm;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\PrettyPrinter\Standard as PhpGenerator;
use Saxulum\ModelGenerator\GeneratorInterface;
use Saxulum\ModelGenerator\Mapping\ModelMapping;
use Saxulum\ModelGenerator\PhpDoc\Documentor;
use Saxulum\ModelGenerator\PhpDoc\ParamRow;

class Generator implements GeneratorInterface
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

    /**
     * @param ModelMapping $modelMapping
     * @param bool $override
     */
    public function generate(ModelMapping $modelMapping, $override = false)
    {
        $namespace = $modelMapping->getBaseNamespace() . '\\' . $modelMapping->getEntityNamespacePart();
        $abstractNamespace = $namespace . '\\Base';

        $path = $modelMapping->getBasePath() . DIRECTORY_SEPARATOR . $modelMapping->getEntityNamespacePart();
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $abstractPath = $path . DIRECTORY_SEPARATOR . 'Base';
        if (!is_dir($abstractPath)) {
            mkdir($abstractPath, 0777, true);
        }

        $abstracClassName = 'Abstract' . $modelMapping->getName();

        $classPath = $path . DIRECTORY_SEPARATOR . $modelMapping->getName() . '.php';
        $abstractClassPath = $abstractPath . DIRECTORY_SEPARATOR . $abstracClassName . '.php';

        $nodes = array();
        $nodes = array_merge($nodes, $this->generatePropertyNodes($modelMapping));
        $nodes = array_merge($nodes, $this->generateMethodNodes($modelMapping));
        $nodes = array_merge($nodes, $this->generateDoctrineOrmMetadataNodes($modelMapping));
        $nodes = array(
            new Node\Stmt\Namespace_(new Name($abstractNamespace), array(
                new Class_('Abstract' . $modelMapping->getName(), array('type' => 16, 'stmts' => $nodes)))
            )
        );
        $abstractClassCode = $this->phpGenerator->prettyPrint($nodes);

        file_put_contents($abstractClassPath, '<?php' . PHP_EOL . PHP_EOL . $abstractClassCode);

        if (file_exists($classPath) && !$override) {
            return;
        }

        $nodes = array(
            new Node\Stmt\Namespace_(new Name($namespace), array(
                new Class_($modelMapping->getName(), array('extends' => new Name($abstractNamespace . '\\' . $abstracClassName)))
            ))
        );

        $classCode = $this->phpGenerator->prettyPrint($nodes);
        file_put_contents($classPath, '<?php' . PHP_EOL . PHP_EOL . $classCode);
    }

    /**
     * @param ModelMapping $modelMapping
     * @return Node[]
     * @throws \Exception
     */
    protected function generatePropertyNodes(ModelMapping $modelMapping)
    {
        return $this->generateNodes($modelMapping, 'getDoctrineOrmPropertyNodes');
    }

    /**
     * @param ModelMapping $modelMapping
     * @return Node[]
     * @throws \Exception
     */
    protected function generateMethodNodes(ModelMapping $modelMapping)
    {
        return $this->generateNodes($modelMapping, 'getDoctrineOrmMethodNodes');
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
                            ))),
                            new MethodCall(new Variable('builder'), 'setMappedSuperClass')
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
