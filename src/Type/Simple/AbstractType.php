<?php

namespace Saxulum\EntityGenerator\Type\Simple;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;
use Saxulum\EntityGenerator\Mapping\FieldMappingInterface;
use Saxulum\PhpDocGenerator\Documentor;
use Saxulum\PhpDocGenerator\ParamRow;
use Saxulum\PhpDocGenerator\ReturnRow;
use Saxulum\PhpDocGenerator\VarRow;
use Saxulum\EntityGenerator\Type\TypeInterface;

abstract class AbstractType implements TypeInterface
{
    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getPropertyNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            new Property(2,
                array(
                    new PropertyProperty($fieldMapping->getName()),
                ),
                array(
                    'comments' => array(
                        new Comment(
                            new Documentor(array(
                                new VarRow($this->getPhpDocType($fieldMapping)),
                            ))
                        ),
                    ),
                )
            ),
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getConstructNodes(FieldMappingInterface $fieldMapping)
    {
        return array();
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node|null
     */
    protected function getSetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        $name = $fieldMapping->getName();

        return new ClassMethod($this->getSetterPrefix().ucfirst($name),
            array(
                'type' => 1,
                'params' => array(
                    new Param($name, $this->getSetterDefault($fieldMapping), $this->getSetterType($fieldMapping)),
                ),
                'stmts' => array(
                    new Assign(
                        new PropertyFetch(new Variable('this'), $name),
                        new Variable($name)
                    ),
                    new Return_(new Variable('this')),
                ),
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new ParamRow($this->getPhpDocType($fieldMapping), $name),
                            new ReturnRow('$this'),
                        ))
                    ),
                ),
            )
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node
     */
    protected function getGetterMethodNode(FieldMappingInterface $fieldMapping)
    {
        $name = $fieldMapping->getName();

        return new ClassMethod($this->getGetterPrefix().ucfirst($name),
            array(
                'type' => 1,
                'stmts' => array(
                    new Return_(new PropertyFetch(new Variable('this'), $name)),
                ),
            ),
            array(
                'comments' => array(
                    new Comment(
                        new Documentor(array(
                            new ReturnRow($this->getPhpDocType($fieldMapping)),
                        ))
                    ),
                ),
            )
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMetadataNodes(FieldMappingInterface $fieldMapping)
    {
        $items = array();

        if (null !== $nullable = $fieldMapping->isNullable()) {
            $items[] = new ArrayItem(new ConstFetch(new Name($nullable ? 'true' : 'false')), new String('nullable'));
        }

        if (null !== $unique = $fieldMapping->isUnique()) {
            $items[] = new ArrayItem(new ConstFetch(new Name($unique ? 'true' : 'false')), new String('unique'));
        }

        if (null !== $columnName = $fieldMapping->getColumnName()) {
            $items[] = new ArrayItem(new String($columnName), new String('columnName'));
        }

        if (null !== $columnDefinition = $fieldMapping->getColumnDefinition()) {
            $items[] = new ArrayItem(new String($columnDefinition), new String('columnDefinition'));
        }

        if (null !== $options = $fieldMapping->getOptions()) {
            $items[] = new ArrayItem($this->covertArrayToNodes($options), new String('options'));
        }

        $items = $this->addOtherMetadataArrayItems($fieldMapping, $items);

        if (count($items) > 0) {
            return array(
                new MethodCall(new Variable('builder'), 'addField', array(
                    new Arg(new String($fieldMapping->getName())),
                    new Arg(new String($this->getName())),
                    new Arg(new Array_($items)),
                )),
            );
        }

        return array(
            new MethodCall(new Variable('builder'), 'addField', array(
                new Arg(new String($fieldMapping->getName())),
                new Arg(new String($this->getName())),
            )),
        );
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @param  array                 $items
     * @return array
     */
    protected function addOtherMetadataArrayItems(FieldMappingInterface $fieldMapping, array $items)
    {
        return $items;
    }

    /**
     * @param  array      $data
     * @return Array
     * @throws \Exception
     */
    protected function covertArrayToNodes(array $data = array())
    {
        $items = array();
        foreach ($data as $key => $value) {
            if (is_int($key)) {
                $itemKey = new String($key);
            } else {
                $itemKey = new LNumber($key);
            }

            if (is_array($value)) {
                $items[] = new ArrayItem($this->covertArrayToNodes($value), $itemKey);
            } elseif (is_string($value) || is_numeric($value)) {
                $items[] = new ArrayItem(new String($value), $itemKey);
            } elseif (is_int($value)) {
                $items[] = new ArrayItem(new LNumber($value), $itemKey);
            } elseif (is_float($value)) {
                $items[] = new ArrayItem(new DNumber($value), $itemKey);
            } elseif (is_bool($value)) {
                $items[] = new ArrayItem(new ConstFetch(new Name($value ? 'true' : 'false')), $itemKey);
            } elseif (is_null($value)) {
                $items[] = new ArrayItem(new ConstFetch(new Name('null')), $itemKey);
            } else {
                throw new \Exception('No object support');
            }
        }

        return new Array_($items);
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return Node[]
     */
    public function getMethodsNodes(FieldMappingInterface $fieldMapping)
    {
        return array(
            $this->getSetterMethodNode($fieldMapping),
            $this->getGetterMethodNode($fieldMapping),
        );
    }

    /**
     * @return string
     */
    protected function getSetterPrefix()
    {
        return 'set';
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return null|Expr
     */
    protected function getSetterDefault(FieldMappingInterface $fieldMapping)
    {
        return;
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return null|string|Name
     */
    protected function getSetterType(FieldMappingInterface $fieldMapping)
    {
        return;
    }

    /**
     * @return string
     */
    protected function getGetterPrefix()
    {
        return 'get';
    }

    /**
     * @param  FieldMappingInterface $fieldMapping
     * @return string
     */
    abstract protected function getPhpDocType(FieldMappingInterface $fieldMapping);
}
