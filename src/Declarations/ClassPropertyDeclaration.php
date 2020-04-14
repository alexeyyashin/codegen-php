<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 17:43
 */
namespace AlexeyYashin\Codegen\Php\Declarations;

use AlexeyYashin\Codegen\Interfaces\CodegenEntity;
use AlexeyYashin\Codegen\Php\PhpFactory;
use AlexeyYashin\Codegen\Php\Traits\ClassMember;

class ClassPropertyDeclaration implements CodegenEntity
{
    use ClassMember;

    protected $ClassObject = null;
    protected $Name = '';
    protected $Value = null;
    protected $Type = null;
    protected $Methods = [];

    public function __construct(/*AlexeyYashin\Codegen\Php\Declarations\PhpCodeClass $class, */ $name)
    {
        $this->Name = estring($name);
    }

    public function getValue()
    {
        return $this->Value;
    }

    public function value($value = null)
    {
        $this->Value = $value;

        return $this;
    }

    public function getType()
    {
        return $this->Type;
    }

    public function setType($value = null)
    {
        $this->Type = $value;

        return $this;
    }

    public function getter($visibility = 'public')
    {
        if ($visibility instanceof ClassMethodDeclaration) {
            $method = $visibility;
        } else {
            $method = PhpFactory::classMethodDeclaration()
                ->setVisibility($visibility)
                ->setBody(PhpFactory::text()->text('return $this->' . $this->Name)->end())
                ->returns($this->Type)
            ;
        }

        $method->setName('get' . $this->Name->toCamelCase());

        return $this->method($method);
    }

    protected function method(ClassMethodDeclaration $method)
    {
        $this->Methods[$method->getName()] = $method;

        return $this;
    }

    public function setter($visibility = 'public')
    {
        if ($visibility instanceof ClassMethodDeclaration) {
            $method = $visibility;
        } else {
            $method = PhpFactory::classMethodDeclaration()
                ->setVisibility($visibility)
                ->argument($this->Name, $this->getType())
                ->setBody(PhpFactory::text()
                    ->text('$this->' . $this->Name . ' = $' . $this->Name)->end()
                    ->text('return $this')->end()
                )
            ;
        }

        $method
            ->setName('set' . $this->Name->toCamelCase())
        ;

        return $this->method($method);
    }

    public function adder($visibility = 'public')
    {
        if ($visibility instanceof ClassMethodDeclaration) {
            $method = $visibility;
        } else {
            $method = PhpFactory::classMethodDeclaration()
                ->setVisibility($visibility)
                ->argument($this->Name, $this->getType())
                ->setBody(PhpFactory::text()
                    ->text('$this->' . $this->Name . '[] = $' . $this->Name)->end()
                    ->text('return $this')->end()
                )
            ;
        }

        $method->setName('add' . $this->Name->toCamelCase());

        return $this->method($method);
    }

    public function getMethods()
    {
        return $this->Methods;
    }

    public function __toString()
    {
        return (string) PhpFactory::text()
            ->text(PhpFactory::format('%s%s $%s%s',
                $this->Visibility,
                PhpFactory::format(' static', $this->Static),
                $this->Name,
                PhpFactory::format(' = %s', $this->Value)
            ))
            ->end()
        ;
    }
}
