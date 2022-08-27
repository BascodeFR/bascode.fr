<?php
namespace Tests\API\Post\Table;

use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\API\Forum\Table\PostTable;
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
        parent::setUp();
        $this->postTable = new PostTable($this->pdo);
        
    }
    

    public function testFind() {
        $this->seedDb();
        
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testFindNotFoundRecord() {
        
        $post = $this->postTable->find(1);
        $this->assertNull($post);
    }

    public function testUpdate(){
        $this->seedDb();
        $this->postTable->update(1, ['name' => 'Salut', 'slug' => 'demo']);
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Salut', $post->name);
        $this->assertEquals('demo', $post->slug);
    }
    public function testInsert(){
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'created_by' => 'afkgku', 'created_at' => "2015-06-05 10:20",'updated_at' => "2015-06-05 10:20"]);
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Salut', $post->name);
        $this->assertEquals('demo', $post->slug);
    }

    public function testDelete(){
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'created_by' => 'afkgku', 'created_at' => "2015-06-05 10:20",'updated_at' => "2015-06-05 10:20"]);
        $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo', 'created_by' => 'afkgku', 'created_at' => "2015-06-05 10:20",'updated_at' => "2015-06-05 10:20"]);
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(2, (int)$count);
        $this->postTable->delete($this->pdo->lastInsertId());
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(1, (int)$count);

    }
}