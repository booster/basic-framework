<?php

namespace Basic\Registry;

use Basic\Interface\BasicProviderInterface;

class ProviderRegistry
{
    public function __construct()
    {
    }

    /**
     * @param array<int, BasicProviderInterface> $providers
     * @return void
     */
    public function configureRegistry(array $providers): void
    {
        foreach ($providers as $provider) {
            $provider->register();
        }
    }
}
