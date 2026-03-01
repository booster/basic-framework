<?php

namespace Basic\Interface;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

interface BasicProviderInterface
{
    public function register(ContainerBuilderInterface $builder): void;
}
