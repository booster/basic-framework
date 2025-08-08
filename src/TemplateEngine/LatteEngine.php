<?php

namespace Basic\TemplateEngine;

use Basic\Interface\TemplateEngine;
use Latte\Engine;

class LatteEngine implements TemplateEngine
{

    public function __construct(private string $templateDir)
    {
    }

    public function render(string $template, array $context = []): string
    {
        $latte = new Engine();
        $latte->setTempDirectory($this->templateDir . '/TemplateCache');

        $template = ltrim($template, '/');

        return $latte->renderToString($this->templateDir . '/Templates/' . $template, $context);
    }
}
