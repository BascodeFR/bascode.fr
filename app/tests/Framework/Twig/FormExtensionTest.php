<?php
namespace Tests\Framework\Twig;

use cavernos\bascode_api\Framework\Twig\FormExtension;
use PhpParser\Node\Expr\Cast\Array_;
use PHPUnit\Framework\TestCase;

class FormExtensionTest extends TestCase  {
        
    /**
     * formExtension
     *
     * @var FormExtension
     */
    private $formExtension;
    
    protected function setUp(): void
    {
        $this->formExtension = new FormExtension();
    }

    private function trim(string $string){
        $lines = explode("\n", $string);
        $lines = array_map('trim', $lines);
        return implode('', $lines);
    }

    public function assertSimilar(string $expected, string $actual){
        $this->assertEquals($this->trim($expected), $this->trim($actual));
    }

    public function testField() {
        $html = $this->formExtension->field([], 'name', 'demo', 'titre');
        $this->assertSimilar("<div class=\"fields admin\">
            <label for=\"name\">titre</label>
            <input type=\"text\" class=\"\" name=\"name\" id=\"name\" value=\"demo\" />
        </div>", $html);
    }
    public function testTextArea() {
        $html = $this->formExtension->field(
            [],
            'name', 
            'demo', 
            'titre',
            ['type' => 'textarea']);
        $this->assertSimilar("<div class=\"fields admin\">
            <label for=\"name\">titre</label>
            <textarea class=\"\" name=\"name\" id=\"name\">demo</textarea>
        </div>", $html);
    }

    public function testError() {
        $context = ['errors' => ['name' => 'erreur']];
        $html = $this->formExtension->field(
            $context,
            'name', 
            'demo', 
            'titre',
            ['type' => 'textarea']);
        $this->assertSimilar("<div class=\"fields admin has-danger\">
            <label for=\"name\">titre</label>
            <textarea class=\"\" name=\"name\" id=\"name\">demo</textarea>
            <small>erreur</small>
        </div>", $html);
    }

    public function testFieldWithClass() {
        $html = $this->formExtension->field([], 
        'name', 
        'demo', 
        'titre',
        ['class' => 'demo']);
        $this->assertSimilar("<div class=\"fields admin\">
            <label for=\"name\">titre</label>
            <input type=\"text\" class=\"demo\" name=\"name\" id=\"name\" value=\"demo\" />
        </div>", $html);
    }

    public function testSelect() {
        $html = $this->formExtension->field([], 
        'name', 
         2, 
        'titre',
        ['options' => [1 => 'Demo', '2' => 'Demo2']]);

        $this->assertSimilar('<div class="fields admin">
        <label for="name">titre</label>
        <select class="" name="name" id="name" />
        <option value="1">Demo</option>
        <option value="2" selected>Demo2</option>
        </select>
    </div>', $html);
    }
    

  
}