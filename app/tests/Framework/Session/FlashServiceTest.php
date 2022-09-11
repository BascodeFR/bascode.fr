<?php

namespace Tests\Framework\Session;

use cavernos\bascode_api\Framework\Session\ArraySession;
use cavernos\bascode_api\Framework\Session\FlashService;
use PHPUnit\Framework\TestCase;

class FlashServiceTest extends TestCase {

    
    /**
     * session
     *
     * @var ArraySession
     */
    private $session;
    
    /**
     * flash
     *
     * @var FlashService
     */
    private $flash;

    protected function setUp(): void
    {
        $this->session = new ArraySession(); 
        $this->flash = new FlashService($this->session);
    }
    


    public function testDeleteFlash(){
        $this->flash->success('Bravo');
        $this->assertEquals('Bravo', $this->flash->get('success'));
        $this->assertNull($this->session->get('flash'));
        $this->assertEquals('Bravo', $this->flash->get('success'));
        $this->assertEquals('Bravo', $this->flash->get('success'));
    }
}