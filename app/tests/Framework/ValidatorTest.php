<?php
namespace Tests\Framework;



use cavernos\bascode_api\Framework\Validator;
use PHPUnit\Framework\TestCase;
use Tests\DatabaseTestCase;

class ValidatorTest extends DatabaseTestCase 
{

    private function makeValidator(array $params) {
        return new Validator($params);

    }
    public function testRequiredIfFail(){

        $errors = $this->makeValidator([
            'name' => 'joe'
        ])
            ->required('name', 'slug')
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    public function testRequirednotEmpty(){

        $errors = $this->makeValidator([
            'name' => ''
        ])
            ->notEmpty('name')
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    public function testRequiredIfSuccess(){

        $errors = $this->makeValidator([
            'name' => 'joe'
        ])
            ->required('name')
            ->getErrors();
        $this->assertCount(0, $errors);
    }

    public function testSlugIfSuccess(){

        $errors = $this->makeValidator([
            'slug' => 'joe-ios34',
            'slug2' => 'joe'
        ])
            ->slug('slug')
            ->slug('slug2')
            ->getErrors();
        $this->assertCount(0, $errors);
    }

    public function testSlugIfFail(){

        $errors = $this->makeValidator([
            'slug' => 'joe-Ios34',
            'slug2' => 'joe-i_os34',
            'slug3' => 'joe--ios34',
            'slug4' => 'joe-ios34-'
        ])
            ->slug('slug')
            ->slug('slug2')
            ->slug('slug3')
            ->slug('slug4')
            ->getErrors();
        $this->assertCount(4, $errors);
    }

    public function testLength(){

        $params = ['slug' => '123456789'];

        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3)->getErrors());
        $errors = $this->makeValidator($params)->length('slug', 12)->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals("Le champ slug doit contenir plus de 12 caracères", (string)$errors['slug']);
        $this->assertCount(1, $this->makeValidator($params)->length('slug', 3, 4)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3, 20)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3, 20)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', null, 20)->getErrors());
        $this->assertCount(1, $this->makeValidator($params)->length('slug',null,  8)->getErrors());

    }

    public function testDateTime() {
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 00:00:00'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2012-21-12'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2013-02-29 11:12:13'])->dateTime('date')->getErrors());
    }

    public function testExists() {
        $pdo = $this->getPdo();
        $pdo->exec('CREATE TABLE test (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(255))');
        $pdo->exec('INSERT INTO test (name) VALUES ("a1")');
        $pdo->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertTrue($this->makeValidator(['category' => 1])->exists('category', 'test', $pdo)->isValid());
        $this->assertFalse($this->makeValidator(['category' => 14242])->exists('category', 'test', $pdo)->isValid());

    }
    
}