<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 20:52
 */
namespace AlexeyYashin\Codegen\Php\Constructions;

use AlexeyYashin\Codegen\LineStreak;

class PhpCodePhpDoc extends LineStreak
{
    public function __toString()
    {
        $a = ['/**'];
        foreach ($this->lines as $line) {
            $a[] = ' * ' . $line;
        }
        $a[] = ' */';
        $this->lines = $a;

        return implode("\n", $this->lines);
    }
}
