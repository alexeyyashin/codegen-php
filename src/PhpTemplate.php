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
    protected $use = [];

    public function __construct($addMark = true)
    {
        $this->addComponent('top', '<?php');
        if ($addMark) {
            $this->addMark();
        }
    }

    public function addNamespace($namespace)
    {
        return $this->addComponent('top', '')->addComponent('top', sprintf('namespace %s;', ltrim($namespace, '\\')))->addEol('top');
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

    protected static function classBaseName(string $name) {
        $l = strrpos($name, '\\');
        return $l ? substr($name, $l + 1) : $name;
    }

    public function useClass(string $name = null, string $alias = null)
    {
        if ($name) {
            $this->use[] = func_get_args();
            return $alias ?? static::classBaseName($name);
        }
        $alreadyUsed = [];
        $this->use = array_filter($this->use, function ($item) use (&$alreadyUsed) {
            if (in_array($item[0], $alreadyUsed, true)) {
                return false;
            }
            $alreadyUsed[] = $item[0];
            return true;
        });
        uasort($this->use, function($a, $b) {
            if ($a[0] === $b[0]) {
                return 0;
            }
            return $a[0] > $b[0] ? 1 : -1;
        });

        return $this->use;
    }

    public function __toString()
    {
        $components = $this->Components;

        foreach ($this->useClass() as $use) {
            $this->addUse(...$use);
        }

        $result = parent::__toString();

        $this->Components = $components;

        return $result;
    }
}
