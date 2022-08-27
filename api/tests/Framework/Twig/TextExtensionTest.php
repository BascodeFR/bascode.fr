<?php
namespace Tests\Framework\Twig;

use cavernos\bascode_api\Framework\Twig\TextExtension;
use PHPUnit\Framework\TestCase;

class TextExtensionTest extends TestCase  {
        
    /**
     * textExtension
     *
     * @var TextExtension
     */
    private $textExtension;
    
    protected function setUp(): void
    {
        $this->textExtension = new TextExtension();
    }
    

    public function testExcerptWithShortText(){
        $text = 'Hello';  
        $this->assertEquals($text, $this->textExtension->excerpt($text, 10));
    }

    public function testExcerptWithLongText(){
        $text = 'Salut les gens';  
        $this->assertEquals('Salut...', $this->textExtension->excerpt($text, 7));
        $this->assertEquals('Salut les...', $this->textExtension->excerpt($text, 12));
    }
}