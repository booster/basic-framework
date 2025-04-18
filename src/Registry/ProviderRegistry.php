<?php

namespace Basic\Registry;

use Basic\Provider\HandlerProvider;
use Psr\Container\ContainerInterface;

class ProviderRegistry
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function registerProviders(): void
    {
        $provider_registry = [
            $this->container->get(HandlerProvider::class),
        ];

        foreach ($provider_registry as $provider) {
            $provider->register();
        }
    }
}
