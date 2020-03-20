<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 16:23
 */
namespace AlexeyYashin\Codegen\Php\Declarations;

use AlexeyYashin\Codegen\Interfaces\CodegenEntity;
use AlexeyYashin\Codegen\LineStreak;
use AlexeyYashin\Codegen\Php\PhpFactory;

class FunctionDeclaration implements CodegenEntity
{
    protected $Name = '';
    protected $Arguments = [];
    protected $Body = '';
    protected $CheckExistence = false;
    protected $returns = null;

    public function __construct($name = '')
    {
        $this->Name = $name;
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

    public function addArgument($argument)
    {
        $this->Arguments[] = $argument;

        return $this;
    }

    public function argument($name, $type = null, $default = null)
    {
        return $this->addArgument(PhpFactory::format('%s%s%s',
            PhpFactory::format('%s ', $type),
            '$' . $name,
            PhpFactory::format(' = %s', $default)
        ));
    }

    public function getBody()
    {
        return $this->Body;
    }

    public function setBody($value = '')
    {
        $this->Body = $value;

        return $this;
    }

    public function getCheckExistence()
    {
        return $this->CheckExistence;
    }

    public function setCheckExistence($value = false)
    {
        $this->CheckExistence = $value;

        return $this;
    }

    public function returns($type)
    {
        $this->returns = $type;

        return $this;
    }

    public function __toString()
    {
        $function = LineStreak
            ::text(PhpFactory::format('function %s(%s)' . PhpFactory::eol() . '{',
                $this->Name,
                implode(', ', $this->Arguments))
            )
            ->text($this->Body)
            ->text('}')
        ;

        if ($this->CheckExistence) {
            return (string) PhpFactory::ifStatement()
                ->setCondition(PhpFactory::format(' ! %s', PhpFactory::functionCall('function_exists')
                    ->addArgument(PhpFactory::format('\'%s\'', $this->Name))
                ))
                ->setBody($function)
            ;
        }

        return (string) $function;
    }
}
