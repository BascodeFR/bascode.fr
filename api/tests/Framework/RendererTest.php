<?php
namespace Tests\Framework;

use cavernos\bascode_api\Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase {
    
    /**
     * renderer
     *
     * @var Renderer
     */
    private $renderer;


    protected function setUp(): void
    {
        $this->renderer = new Renderer(); 
        $this->renderer->addPath( __DIR__ . '/views');
    }

    public function testRenderRightPath(){
        $this->renderer->addPath('post', __DIR__ . '/views');
        $content = $this->renderer->render('@post/demo');
        $this->assertEquals('Salut le peuple', $content);

    }

    public function testRenderDefaultPath(){
        $content = $this->renderer->render('demo');
        $this->assertEquals('Salut le peuple', $content);

    }

    public function testRenderWithParams(){
        $content = $this->renderer->render('demoparams', ['id' => "5"]);
        $this->assertEquals('Salut 5', $content);

    }

    public function testRenderWithGlobalParams(){
        $this->renderer->addGlobal('id', "5");
        $content = $this->renderer->render('demoparams', ['id' => "5"]);
        $this->assertEquals('Salut 5', $content);

    }
    
}