<?php
declare(strict_types=1);
namespace Basic\Registry;

use Basic\Interface\BasicProviderInterface;
use Basic\Interface\ContainerBuilderInterface;

class ProviderRegistry
{
    /**
     * TODO: replace with containerBuilder, since the container instance cannot be assigned new entries.
     *
     * @param ContainerBuilderInterface $containerBuilder
     */
    public function __construct(private readonly ContainerBuilderInterface $containerBuilder)
    {
    }

    /**
     * @param array<int, BasicProviderInterface> $providers
     * @return void
     */
    public function configureRegistry(array $providers): void
    {
        foreach ($providers as $provider) {
            $provider->register($this->containerBuilder);
        }
    }
}
