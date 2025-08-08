<?php

namespace Basic\Interface;

interface TemplateEngine
{
    public function render(string $template, array $context = []): string;
}
