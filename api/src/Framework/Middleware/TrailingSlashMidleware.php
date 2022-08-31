<?php
namespace cavernos\bascode_api\Framework\MiddleWare;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TrailingSlashMidleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === '/' && $uri !== '/') {
            return (new Response())
                    ->withStatus(301)
                    ->withHeader('Location', substr($uri, 0, -1));
        }
        return $next($request);
    }
}
