<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 17:35
 */
namespace AlexeyYashin\Codegen\Php\Declarations;

use AlexeyYashin\Codegen\Php\PhpFactory;
use AlexeyYashin\Codegen\Php\Traits\ClassMember;

class ClassMethodDeclaration extends FunctionDeclaration
{
    use ClassMember;

    protected $Abstract = false;

    public function getAbstract()
    {
        return $this->Abstract;
    }

    public function setAbstract($value = false)
    {
        $this->Abstract = $value;

        return $this;
    }

    public function abstract()
    {
        $this->setAbstract(true);

        return $this;
    }

    public function __toString()
    {
        if ($this->Abstract) {
            return (string) PhpFactory::format('abstract%2$s%3$s function %1$s(%4$s)%5$s;',
                $this->Name,
                $this->Visibility,
                PhpFactory::format('static', $this->Static),
                implode(', ', $this->Arguments),
                PhpFactory::format(': %s', $this->returns)
            );
        }

        return (string) PhpFactory::text()
            ->text(PhpFactory::format('%2$s%3$s function %1$s(%4$s)%5$s' . PhpFactory::eol() . '{' . PhpFactory::eol()
                . '%6$s' . '}',
                $this->Name,
                $this->Visibility,
                PhpFactory::format(' static', $this->Static),
                implode(', ', $this->Arguments),
                PhpFactory::format(': %s', $this->returns),
//                PhpFactory::text()->text($this->Body)
                $this->Body
            ))
        ;
    }
}
