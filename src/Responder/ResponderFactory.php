<?php
declare(strict_types=1);
namespace Basic\Responder;

use Basic\Interface\ResponderInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Using Content Negotiation to read format the correct response based on header Accept
 * @see https://www.php-fig.org/psr/psr-7/ - public function withParsedBody($data);
 */
readonly class ResponderFactory
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function getResponder(ServerRequestInterface $serverRequest): ResponderInterface
    {
        $accept = $serverRequest->getHeaderLine('Accept');

        $accept_parts = explode(',', $accept);

        return match ($accept_parts[0]) {
            'application/json' => $this->container->get(JsonResponder::class),
            default => $this->container->get(HtmlResponder::class),
        };
    }
}
