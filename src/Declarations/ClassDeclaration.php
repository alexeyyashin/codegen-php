<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 20:30
 */
namespace AlexeyYashin\Codegen\Php\Declarations;

use AlexeyYashin\Codegen\Interfaces\CodegenEntity;
use AlexeyYashin\Codegen\Php\PhpFactory;

class ClassDeclaration implements CodegenEntity
{
    public function __construct(string $name = '')
    {
        $this->Name = $name;
    }

    protected $Name = '';

    public function getName()
    {
        return $this->Name;
    }

    public function setName($value = '')
    {
        $this->Name = $value;

        return $this;
    }

    protected $Methods = [];

    public function getMethods()
    {
        return $this->Methods;
    }

    public function setMethods($value = [])
    {
        $this->Methods = $value;

        return $this;
    }

    public function method(ClassMethodDeclaration $method)
    {
        $this->Methods[$method->getName()] = $method;

        return $this;
    }

    protected $Properties = [];

    public function property(ClassPropertyDeclaration $property)
    {
        $this->Properties[] = $property;

        return $this;
    }

    protected $Extends = null;

    public function extends($class)
    {
        $this->Extends = $class;
        return $this;
    }

    public function __toString()
    {
        $resultText = '';
        $resultText .= PhpFactory::format('class %s%s' . PhpFactory::eol() . '{',
            $this->Name,
            PhpFactory::format(' extends %s', $this->Extends)
        );

        $props = '';
        foreach ($this->Properties as $property) {
            $props .= rtrim($property);

            foreach ($property->getMethods() as $method) {
                $this->Methods[$method->getName()] = $method;
            }
        }

        $resultText .= PhpFactory::format('%s' . PhpFactory::eol(), $props);

        foreach ($this->Methods as $method) {
            $resultText .= $method;
        }
        $resultText .= '}';

        return (string) PhpFactory::text()->text($resultText);
    }
}
