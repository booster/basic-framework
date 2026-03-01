<?php

namespace Basic\Adapter;

use Basic\Interface\ContainerBuilderInterface;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class PhpDIAdapter implements ContainerBuilderInterface
{
    private ContainerBuilder $builder;

    public function __construct() {
        $this->builder = new ContainerBuilder();
    }
    public function addDefinitions(array $definitions): void
    {
        $this->builder->addDefinitions($definitions);
    }

    public function build(): ContainerInterface
    {
        return $this->builder->build();
    }
}