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
use AlexeyYashin\Codegen\Php\Statements\IfStatement;

/**
 * Class PhpFactory
 * @package AlexeyYashin\Codegen\Php
 */
class PhpFactory extends Factory
{
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
}
