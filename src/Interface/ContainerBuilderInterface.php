<?php

namespace Basic\Interface;

use Psr\Container\ContainerInterface;

interface ContainerBuilderInterface
{
    public function addDefinitions(array $definitions): void;
    public function build(): ContainerInterface;
}
