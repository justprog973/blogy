<?php

namespace Framework\Router;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Route
 * Represent a matched route
 */
class Route
{

    public function __construct(private string $name, private \callable $callback, private array $parameters)
    {
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * getCallback
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * Retrieve the URL Parameters
     *
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->parameters;
    }
}
