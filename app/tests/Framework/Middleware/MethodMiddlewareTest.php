<?php
namespace Tests\Framework\Middleware;

use cavernos\bascode_api\Framework\Middleware\MethodMiddleware;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MethodMiddlewareTest extends TestCase {
    
    /**
     * middleware
     *
     * @var MethodMiddleware
     */
    private $middleware;
    
    protected function setUp(): void
    {
       $this->middleware = new MethodMiddleware();
        // 
    }
    

    public function testAddMethod() {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
        ->setMethods(['handle'])
        ->getMock();

        $handle->expects($this->once())
            ->method('handle')
            ->with($this->callback(function (ServerRequestInterface $request) {
                return $request->getMethod() === 'DELETE';
            }));

        $request = (new ServerRequest('POST', '/demo'))
        ->withParsedBody(['_METHOD' => "DELETE"]);
        $this->middleware->process($request, $handle);
    }
}