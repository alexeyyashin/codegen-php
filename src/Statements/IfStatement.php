<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 16:18
 */
namespace AlexeyYashin\Codegen\Php\Statements;

use AlexeyYashin\Codegen\Interfaces\CodegenEntity;
use AlexeyYashin\Codegen\LineStreak;
use AlexeyYashin\Codegen\Php\PhpFactory;

class IfStatement implements CodegenEntity
{
    protected $Condition = 'true';
    protected $Body = '';
    protected $ElseBody = '';

    public function getCondition()
    {
        return $this->Condition;
    }

    public function setCondition($value = 'true')
    {
        $this->Condition = $value;

        return $this;
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

    public function getElseBody()
    {
        return $this->ElseBody;
    }

    public function setElseBody($value = '')
    {
        $this->ElseBody = $value;

        return $this;
    }

    public function __toString()
    {
        $Lines = LineStreak
            ::line(PhpFactory::format('if (%s) {', $this->Condition))
            ->text($this->Body)
        ;

        if ($this->ElseBody) {
            $Lines
                ->line('} else {')
                ->text($this->ElseBody)
            ;
        }
        $Lines->text('}');

        return (string) $Lines;
    }
}
