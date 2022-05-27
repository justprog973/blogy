<?php

namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/***
 *
 * Add methods linked to use router
 *
 * Trait RouterAwareAction
 * @package Framework\Actions
 */
trait RouterAwareAction
{
    /**
     * Send reponse of redirect
     * redirect
     *
     * @param  string $path
     * @param  array $params
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = []): ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('Location', $redirectUri);
    }
}
