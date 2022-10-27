<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 16:11
 */

namespace AlexeyYashin\Codegen\Php;

use AlexeyYashin\Codegen\Factory;
use AlexeyYashin\Codegen\Php\Constructions\FunctionCall;
use AlexeyYashin\Codegen\Php\Declarations\ClassMethodDeclaration;
use AlexeyYashin\Codegen\Php\Declarations\ClassPropertyDeclaration;
use AlexeyYashin\Codegen\Php\Declarations\FunctionDeclaration;
use AlexeyYashin\Codegen\Php\Declarations\ClassDeclaration;
use AlexeyYashin\Codegen\Php\Statements\EscapeMk;
use AlexeyYashin\Codegen\Php\Statements\IfStatement;

/**
 * Class PhpFactory
 * @package AlexeyYashin\Codegen\Php
 */
class PhpFactory extends Factory
{
    public static function eol()
    {
        return "\n";
    }

    public static function ifStatement()
    {
        return new IfStatement();
    }

    public static function functionCall(string $name)
    {
        return new FunctionCall($name);
    }

    public static function functionDeclaration(string $name = '')
    {
        return new FunctionDeclaration($name);
    }

    public static function classPropertyDeclaration(string $name)
    {
        return new ClassPropertyDeclaration($name);
    }

    public static function classDeclaration(string $name)
    {
        return new ClassDeclaration($name);
    }

    public static function classMethodDeclaration(string $name = '')
    {
        return new ClassMethodDeclaration($name);
    }

    public static function mk($arr, $req = 0)
    {
        $LF = "\n";
        $TAB = '    ';
        $TT = str_repeat($TAB, $req);

        $STR = '';

        $escape = function($v)
        {
            return str_replace(
                ['\'',   '\\'],
                ['\\\'', '\\\\'],
                $v
            );
        };

        if ($arr instanceof EscapeMk) {
            $STR .= (string) $arr;
        }
        elseif (is_array($arr))
        {
            if ( ! $arr)
            {
                $STR .= '[]';
            }
            else
            {
                $STR .= '[' . $LF;
                foreach ($arr as $k => $v)
                {
                    if (is_string($k))
                    {
                        $k = sprintf('\'%s\'', $k);
                    }
                    $STR .= sprintf(
                        $TT . $TAB . '%s => %s,' . $LF,
                        $k,
                        static::mk($v, $req + 1)
                    );
                }
                $STR .= $TT . ']';
            }
        }
        elseif (is_string($arr))
        {
            $STR .= sprintf('\'%s\'', $escape($arr));
        }
        elseif (is_numeric($arr))
        {
            $STR .= $arr;
        }
        elseif ($arr === true)
        {
            $STR .= 'true';
        }
        elseif ($arr === false)
        {
            $STR .= 'false';
        }
        elseif ($arr === null)
        {
            $STR .= 'null';
        }
        else
        {
            $STR .= sprintf(
                '\'%s\'',
                $escape(serialize($arr))
            );
        }

        return strlen($STR) ? $STR : 'null';
    }

    public static function format($template, ...$params)
    {
        if (reset($params)) {
            foreach ($params as &$param) {
                if (is_array($param)) {
                    $param = self::mk($param);
                }
            }
            return estring(sprintf($template, ...$params));
        }

        return estring('');
    }

    public static function escapeMk(string $value)
    {
        return new EscapeMk($value);
    }
}
