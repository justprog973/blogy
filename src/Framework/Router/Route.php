<?php

namespace Framework\Router;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Route
 * Represent a matched route
 */
class Route
{

    private string $name;

    private $callback;

    private array $parameters;

    public function __construct(string $name, callable $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
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
