<?php
namespace Tests\API\Post\Actions;

use cavernos\bascode_api\API\Post\Actions\PostAction;
use cavernos\bascode_api\API\Post\Table\PostTable;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophet;
use stdClass;

class PostActionTest extends TestCase{
        
    /**
     * action
     *
     * @var PostAction
     */
    private $action;
    private $prophet;
    private $renderer;
    private $postTable;
    private $router;

    protected function setUp(): void
    {
        $this->prophet = new Prophet();

        $this->renderer = $this->prophesize(RendererInterface::class);

        $this->postTable = $this->prophet->prophesize(PostTable::class);
        $this->router = $this->prophet->prophesize(Router::class);
        $this->action = new PostAction($this->renderer->reveal(), $this->postTable->reveal(), $this->router->reveal());
         
    }

    public function makePost(int $id, string $slug): stdClass{
        $post = new stdClass();
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }
    

    public function testShowRedirect(){
        $post = $this->makePost(9, 'gqgqqsdgqg-vqsdg');
        $this->router->generateUri('post.show', ['id' =>  $post->id, 'slug' =>  $post->slug])->willReturn('/demo2');
        $this->postTable->find($post->id)->willReturn($post);
        $request = (new ServerRequest('GET', '/'))->withAttribute('id', $post->id)->withAttribute('slug', 'demo');
        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['/demo2'], $response->getHeader('Location'));
    }

    public function testShowRender(){
        $post = $this->makePost(9, 'gqgqqsdgqg-vqsdg');
        $this->postTable->find($post->id)->willReturn($post);


        $request = (new ServerRequest('GET', '/'))->withAttribute('id', $post->id)->withAttribute('slug', $post->slug);
        $this->renderer->render('@post/index', ['post' => $post])->willReturn('');
        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals('true', 'true');
    }
}