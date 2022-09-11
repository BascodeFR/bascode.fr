<?php
namespace Tests\Framework\Middleware;

use cavernos\bascode_api\Framework\Exception\CsrfInvalidException;
use cavernos\bascode_api\Framework\Middleware\CsrfMiddleware;
use Exception;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

class CsrfMiddlewareTest extends TestCase {
    
    /**
     * middleware
     *
     * @var CsrfMiddleware
     */
    private $middleware;
    
    /**
     * session
     *
     * @var array
     */
    private $session;
    
    protected function setUp(): void
    {
        $this->session = [];
        $this->middleware = new CsrfMiddleware($this->session);
    
    }
    

    public function testLetGetRequestPass() {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['handle'])
        ->getMock();

        $handle->expects($this->once())
            ->method('handle')
            ->willReturn(new Response());

        $request = (new ServerRequest('GET', '/demo'));
        $this->middleware->process($request, $handle);
    }

    public function testBlockPostsRequestWithoutCsrf() {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['handle'])
        ->getMock();

        $handle->expects($this->never())
            ->method('handle');

        $request = (new ServerRequest('POST', '/demo'));
        $this->expectException(CsrfInvalidException::class);
        $this->middleware->process($request, $handle);
    }

    public function testLetPostWithTokenPass() {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['handle'])
        ->getMock();

        $handle->expects($this->once())
            ->method('handle')
            ->willReturn(new Response());

        $request = (new ServerRequest('POST', '/demo'));
        $token = $this->middleware->generateToken();
        $request = $request->withParsedBody(['_csrf' => $token]);
        $this->middleware->process($request, $handle);
    }

    public function testBlockPostsRequestWithInvalidCsrf() {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['handle'])
        ->getMock();

        $handle->expects($this->never())
            ->method('handle');

        $this->middleware->generateToken();
        $request = (new ServerRequest('POST', '/demo'));
        $request = $request->withParsedBody(['_csrf' => 'qugfguq<i']);
        $this->expectException(CsrfInvalidException::class);
        $this->middleware->process($request, $handle);
    }

    public function testLetPostWithTokenPassOnce() {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['handle'])
        ->getMock();

        $handle->expects($this->once())
            ->method('handle')->willReturn(new Response());

        $request = (new ServerRequest('POST', '/demo'));
        $token = $this->middleware->generateToken();
        $request = $request->withParsedBody(['_csrf' => $token]);
        $this->middleware->process($request, $handle);
        $this->expectException(CsrfInvalidException::class);
        $this->middleware->process($request, $handle);
    }

    public function testLimitTokenNumber() {
        
        for($i = 0; $i < 100; ++$i) {
            $token = $this->middleware->generateToken();
        }
        $this->assertCount(50, $this->session['csrf']);
        $this->assertEquals($token, $this->session['csrf'][49]);
    }
}