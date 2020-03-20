<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 16:47
 */
namespace AlexeyYashin\Codegen\Php\Constructions;

use AlexeyYashin\Codegen\Interfaces\CodegenEntity;
use AlexeyYashin\Codegen\Php\PhpFactory;

class FunctionCall implements CodegenEntity
{
    protected $Name = '';
    protected $Arguments = [];
    protected $CallEnd = '';

    public function __construct($name)
    {
        $this->setName($name);
    }

    public function getName()
    {
        return $this->Name;
    }

    public function setName($value = '')
    {
        $this->Name = $value;

        return $this;
    }

    public function getArguments()
    {
        return $this->Arguments;
    }

    public function setArguments($value = [])
    {
        $this->Arguments = $value;

        return $this;
    }

    public function addArgument($value)
    {
        $this->Arguments[] = $value;

        return $this;
    }

    public function semicolon()
    {
        $this->CallEnd = ';';

        return $this;
    }

    public function __toString()
    {
        return (string) PhpFactory::format('%s(%s)%s',
            $this->Name,
            implode(', ', $this->Arguments),
            $this->CallEnd
        );
    }
}