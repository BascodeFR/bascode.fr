<?php
namespace Tests\API\Post\Table;

use cavernos\bascode_api\API\Post\Entity\Post;
use cavernos\bascode_api\API\Post\Table\PostTable;
use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
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
}