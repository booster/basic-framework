<?php
declare(strict_types=1);

namespace Basic\Provider;
use Basic\Handler\GetHandler;
use Basic\Handler\PostHandler;
use Basic\Interface\BasicProviderInterface;
use Basic\Interface\ContainerBuilderInterface;
use function DI\autowire;

class HandlerProvider implements BasicProviderInterface
{
    public function register(ContainerBuilderInterface $builder): void
    {
        $builder->addDefinitions([
            'GET' => autowire(GetHandler::class),
            'POST' => autowire(PostHandler::class),
        ]);
    }
}
