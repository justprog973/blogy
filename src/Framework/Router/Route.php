<?php

namespace Framework\Router;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Route
 * Represent a matched route
 */
class Route
{

    /**
     * __construct
     *
     * @param  string $name
     * @param  callable|string $callback
     * @param  array $parameters
     * @return void
     */
    public function __construct(private string $name, private \callable|string $callback, private array $parameters)
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
    public function getCallback(): callable|string
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
