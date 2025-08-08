<?php

namespace Basic\Facade;

use Basic\Interface\TemplateEngine;

class View
{

    private static ?View $instance = null;

    private static TemplateEngine $engine;

    private function __construct()
    {
    }

    public static function setInstance(TemplateEngine $engine): View
    {
        self::$engine = $engine;

        return self::$instance ??= new View();
    }

    public static function render(string $template, array $context = []): string
    {
        return self::$engine->render(template: $template, context: $context);
    }
}