<?php
namespace Tests\Framework\Database;

use cavernos\bascode_api\Framework\Database\Query;
use Tests\DatabaseTestCase;

class QueryTest extends DatabaseTestCase {


    public function testSimpleQuery() {
        $query = (new Query($this->getPdo()))->from('posts')->select('name');
        $this->assertEquals("SELECT name FROM posts", (string)$query);
    }

    public function testWithWhere() {
        $query = (new Query($this->getPdo()))->where('a = :a OR b = :b', 'c = :c')->from('posts', 'p');
        $this->assertEquals("SELECT * FROM posts as p WHERE (a = :a OR b = :b) AND (c = :c)", (string)$query);

        $query2 = (new Query($this->getPdo()))->where('a = :a OR b = :b')->where('c = :c')->from('posts', 'p');
        $this->assertEquals("SELECT * FROM posts as p WHERE (a = :a OR b = :b) AND (c = :c)", (string)$query2);
    }

    public function testFetchAll() {
        $pdo = $this->getPdo();
        $this->migrateDb($pdo);
        $this->seedDb($pdo);

        $query = (new Query($pdo))
        ->from('posts', 'p')->count();
        $this->assertEquals(100, $query);

        $posts = (new Query($pdo))
        ->from('posts', 'p')
        ->where('p.id < :number')
        ->params([
            'number' => 30
        ])->count();

        $this->assertEquals(29, $posts);
    }

    public function testHydrateEntity() {
        $pdo = $this->getPdo();
        $this->migrateDb($pdo);
        $this->seedDb($pdo);

        $query = (new Query($pdo))
        ->from('posts', 'p')
        ->into(Demo::class)
        ->fetchAll();
        $this->assertEquals('demo', substr($query[0]->getSlug(), -4));

    
    }

    public function testLazyHydrate() {
        $pdo = $this->getPdo();
        $this->migrateDb($pdo);
        $this->seedDb($pdo);

        $query = (new Query($pdo))
        ->from('posts', 'p')
        ->into(Demo::class)
        ->fetchAll();
        $post = $query[0];
        $post2 = $query[0];
        $this->assertSame($post, $post2);

    
    }

    public function testJoinQuery() {
        $query = (new Query($this->getPdo()))->from('posts', 'p')->select('name')
        ->join('messages as m', 'p.id = m.post_id')
        ->join('messages as m2', 'p.id = m2.post_id', 'inner');
        $this->assertEquals("SELECT name FROM posts as p LEFT JOIN messages as m ON p.id = m.post_id INNER JOIN messages as m2 ON p.id = m2.post_id", (string)$query);
    }

    public function testOrderQuery() {
        $query = (new Query($this->getPdo()))->from('posts', 'p')->select('name')
        ->order('id DESC')
        ->order('name ASC')
        ->limit(10, 5);
        $this->assertEquals("SELECT name FROM posts as p ORDER BY id DESC, name ASC LIMIT 5, 10", (string)$query);
    }

    
}