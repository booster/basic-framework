<?php
declare(strict_types=1);
namespace Basic\Bootstrap;

use Basic\Adapter\PhpDIAdapter;
use Basic\Controller\Contact;
use Basic\Controller\Frontpage;
use Basic\Controller\NewContact;
use Basic\Dispatcher\RouteDispatcher;
use Basic\Facade\View;
use Basic\Handler\BasicMiddlewareHandler;
use Basic\Interface\BasicProviderInterface;
use Basic\Interface\ContainerBuilderInterface;
use Basic\Interface\TemplateEngine;
use Basic\Middleware\RouteMiddleware;
use Basic\Provider\HandlerProvider;
use Basic\Provider\TemplateEngineProvider;
use Basic\RequestDTO\FrontpageRequestDTO;
use Basic\RequestDTO\RequestDTOFactory;
use Basic\RequestDTOValidation\RequestDTONullableRule;
use Basic\RequestDTOValidation\RequestDTORequiredRule;
use Basic\RequestDTOValidation\RequestDTOTypeRule;
use Basic\RequestDTOValidation\RequestDTOValidator;
use Basic\Responder\HtmlResponder;
use Basic\Responder\JsonResponder;
use Basic\Responder\ResponderFactory;
use Basic\Route\Router;
use Basic\TemplateEngine\LatteEngine;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;
use function DI\autowire;

class BootstrapApp
{
    private ContainerInterface $container;

    public function __construct()
    {
        $this->bootstrap();
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

    private function bootstrap(): void
    {
        $builder = $this->getBuilderAdapter();

        $this->registerCoreDefinitions(builder: $builder);

        $this->registerProviders(builder: $builder);

        $this->container = $builder->build();

        $this->boot();
    }

    private function registerCoreDefinitions(ContainerBuilderInterface $builder): void
    {
        $builder->addDefinitions([
            // Controllers
            Frontpage::class => autowire(),
            Contact::class => autowire(),
            NewContact::class => autowire(),

            // Middleware & Routing
            RouteMiddleware::class => autowire(),
            RouteDispatcher::class => autowire(),
            Router::class => autowire(),
            BasicMiddlewareHandler::class => autowire(),

            // Request/Response
            ResponderFactory::class => autowire(),
            RequestDTOFactory::class => autowire(),
            FrontpageRequestDTO::class => autowire(), // not required for the RequestDTO's to be in the container, but you can for DI :)
            HtmlResponder::class => autowire(),
            JsonResponder::class => autowire(),

            // Validation
            RequestDTOValidator::class => function () {
                return new RequestDTOValidator(
                    new RequestDTONullableRule(),
                    new RequestDTORequiredRule(),
                    new RequestDTOTypeRule(),
                );
            },

            // Template Engine (Default implementation, can be overridden by provider)
            TemplateEngine::class => function () {
                return new LatteEngine(dirname(__FILE__, 2) . '/TemplateEngine');
            }
        ]);
    }

    private function bootMiddleware(): void
    {
        /** @var BasicMiddlewareHandler $request_handler */
        $request_handler = $this->container->get(BasicMiddlewareHandler::class);

        $request_handler->setMiddlewareStack([
            $this->container->get(RouteMiddleware::class),
        ]);
    }

    private function bootRoutes(): void
    {
        /** @var Router $router */
        $router = $this->container->get(Router::class);

        // GET
        $router->get('/', fn() => $this->container->make(Frontpage::class));
        $router->get('/contact', fn() => $this->container->make(Contact::class));

        // POST
        $router->post('/contact', fn() => $this->container->make(NewContact::class));
    }

    private function registerProviders(ContainerBuilderInterface $builder): void
    {
        $providers = $this->getProviders();

        foreach ($providers as $provider) {
            $provider->register(builder: $builder);
        }
    }

    private function bootFacades(): void
    {
        View::setInstance($this->container->get(TemplateEngine::class));
    }

    /**
     * @return array<int, BasicProviderInterface>
     */
    private function getProviders(): array
    {
        return [
            new HandlerProvider(),
            new TemplateEngineProvider(),
        ];
    }

    /**
     * Replace with another adapter if other PSR Container is wanted
     *
     * @return ContainerBuilderInterface
     */
    public function getBuilderAdapter(): ContainerBuilderInterface
    {
        return new PhpDIAdapter();
    }

    private function boot(): void
    {
        $this->bootMiddleware();
        $this->bootRoutes();
        $this->bootFacades();
    }


}
