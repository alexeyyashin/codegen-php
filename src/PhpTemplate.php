<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 15:30
 */
namespace AlexeyYashin\Codegen\Php;

use AlexeyYashin\Codegen\LineStreak;
use AlexeyYashin\Codegen\Php\Constructions\PhpCodePhpDoc;
use AlexeyYashin\Codegen\Template;

class PhpTemplate extends Template
{
    public function __construct($addMark = true)
    {
        $this->addComponent('top', '<?php');
        if ($addMark) {
            $this->addMark();
        }
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

    protected function addMark()
    {
        $this->addComponent(self::TYPE_TOP, (new PhpCodePhpDoc())
            ->line('This file was automatically generated')
            ->line('using alexeyyashin/codegen-php')
            ->line('@see https://github.com/alexeyyashin/codegen-php')
            ->line()
            ->line('at ' . date('Y-m-d H:i:s') . "\n")
        );
    }
}
