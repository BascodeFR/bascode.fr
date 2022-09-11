<?php
namespace Tests\API\Post\Table;

use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\API\Forum\Table\PostTable;
use cavernos\bascode_api\Framework\Database\NoRecordException;
use Tests\DatabaseTestCase;

class PostTableTest extends DatabaseTestCase {
    
    /**
     * postTable
     *
     * @var PostTable
     */
    private $postTable;

    public function setUp(): void
    {
        $pdo = $this->getPdo();
        $this->migrateDb($pdo);
        $this->postTable = new PostTable($pdo);
        
    }
    

    public function testFind() {
        $this->seedDb($this->postTable->getPdo());
        
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testFindNotFoundRecord() {
       $this->expectException(NoRecordException::class);
        $this->postTable->find(1);
    }

    public function testUpdate(){
        $this->seedDb($this->postTable->getPdo());
        $this->postTable->update(1, ['name' => 'Salut', 'slug' => 'demo']);
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Salut', $post->name);
        $this->assertEquals('demo', $post->slug);
    }
    public function testInsert(){
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'user_id' => 8, 'created_at' => "2015-06-05 10:20",'updated_at' => "2015-06-05 10:20"]);
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Salut', $post->name);
        $this->assertEquals('demo', $post->slug);
    }

    public function testDelete(){
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'user_id' => 8, 'created_at' => "2015-06-05 10:20",'updated_at' => "2015-06-05 10:20"]);
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'user_id' => 8, 'created_at' => "2015-06-05 10:20",'updated_at' => "2015-06-05 10:20"]);
        $count =  $this->postTable->getPdo()->query('SELECT COUNT(id) FROM threads')->fetchColumn();
        $this->assertEquals(2, (int)$count);
        $this->postTable->delete($this->postTable->getPdo()->lastInsertId());
        $count = $this->postTable->getPdo()->query('SELECT COUNT(id) FROM threads')->fetchColumn();
        $this->assertEquals(1, (int)$count);

    }
}