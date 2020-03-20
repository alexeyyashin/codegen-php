<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 15:30
 */
namespace AlexeyYashin\Codegen\Php;

use AlexeyYashin\Codegen\LineStreak;
use AlexeyYashin\Codegen\Template;

class PhpTemplate extends Template
{
    public function __construct()
    {
        $this->addComponent('top', '<?php');
    }

    public function addNamespace($namespace)
    {
        return $this->addComponent('top', sprintf('namespace %s;', $namespace))->addEol('top');
    }

    public function addUse($classname, $alias = null)
    {
        return $this->addComponent('top', $this->formatIf(
            'use %s%s;',
            $classname,
            $this->formatIf(' as %s', $alias)
        ));
    }

    public function addComment($body)
    {
        return $this->addComponent('simple', LineStreak
            ::line('/*')
            ->text($body)
            ->line('*/')
        );
    }
}
