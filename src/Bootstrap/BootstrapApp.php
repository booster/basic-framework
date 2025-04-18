<?php
declare(strict_types=1);
namespace Basic\Bootstrap;

use Basic\Controller\Contact;
use Basic\Handler\GetHandler;
use Basic\Handler\PostHandler;
use Basic\Provider\HandlerProvider;
use Basic\Registry\ProviderRegistry;
use DI\Container;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;
use Basic\Controller\Frontpage;
use Basic\Dispatcher\RouteDispatcher;
use Basic\Handler\BasicMiddlewareHandler;
use Basic\Middleware\RouteMiddleware;
use Basic\Route\Router;
use function DI\autowire;

class BootstrapApp
{
    private ContainerInterface $container;

    public function __construct()
    {
        $this->container = $this->createContainer();
        $this->registerMiddleware();
        $this->registerRoutes();
        $this->registerProviders();
    }

    public function run(): bool
    {
        $psr17Factory = new Psr17Factory();
        $creator = new ServerRequestCreator($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $server_request = $creator->fromGlobals();
        /** @var BasicMiddlewareHandler $requestHandler */
        $requestHandler = $this->container->get(BasicMiddlewareHandler::class);

        $emitter = new SapiEmitter();

        return $emitter->emit($requestHandler->handle($server_request));
    }

    private function createContainer(): ContainerInterface
    {
        return new Container([
            Frontpage::class => autowire(Frontpage::class),
            Contact::class => autowire(Contact::class),
            RouteMiddleware::class => autowire(RouteMiddleware::class),
            RouteDispatcher::class => autowire(RouteDispatcher::class),
            Router::class => autowire(Router::class),
            GetHandler::class => autowire(GetHandler::class),
            PostHandler::class => autowire(PostHandler::class),
            BasicMiddlewareHandler::class => autowire(BasicMiddlewareHandler::class),
            HandlerProvider::class => autowire(HandlerProvider::class),
            ProviderRegistry::class  => autowire(ProviderRegistry::class),
        ]);
    }

    private function registerMiddleware(): void
    {
        /** @var BasicMiddlewareHandler $request_handler */
        $request_handler = $this->container->get(BasicMiddlewareHandler::class);
        $request_handler->setMiddlewareStack([
            $this->container->get(RouteMiddleware::class),
        ]);
    }

    private function registerRoutes(): void
    {
        $container = $this->container;
        /** @var Router $router */
        $router = $container->get(Router::class);

        $router->get('/contact', function () use ($container) {
            return $container->get(Contact::class);
        });

        $router->get('/', function () use ($container) {
            return $container->get(Frontpage::class);
        });

        $router->post('/contact', function () use ($container) {
           return $container->get(Contact::class);
        });
    }

    private function registerProviders(): void
    {
        /** @var ProviderRegistry $provider_registry */
        $provider_registry = $this->container->get(ProviderRegistry::class);

        $provider_registry->registerProviders();
    }
}
