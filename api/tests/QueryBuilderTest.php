<?php

use cavernos\bascode_api\Helpers\PDOHelpers;
use cavernos\bascode_api\Helpers\QueryBuilder;
use PDO;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class QueryBuilderTest extends TestCase{
    public function getPDO(): PDO{
        $pdo = PDOHelpers::getPDO('Bascode', '192.168.0.6', 'minecraft', 'mak2Mak!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $pdo;
    }

    public function getBuilder(){
        return new QueryBuilder();
    }

    public function testSimpleQuery(){
        $q = $this->getBuilder()->from("post", "p")->toSQL();
        $this->assertEquals("SELECT * FROM post p", $q);
    }
    public function testOrderBy()
    {
        $q = $this->getBuilder()->from("post", "p")->orderBy("id", "DESC")->toSQL();
        $this->assertEquals("SELECT * FROM post p ORDER BY id DESC", $q);
    }

    public function testMultipleOrderBy()
    {
        $q = $this->getBuilder()
            ->from("post")
            ->orderBy("id", "ezaearz")
            ->orderBy("name", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM post ORDER BY id, name DESC", $q);
    }

    public function testLimit()
    {
        $q = $this->getBuilder()
            ->from("post")
            ->limit(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM post ORDER BY id DESC LIMIT 10", $q);
    }

    public function testOffset()
    {
        $q = $this->getBuilder()
            ->from("post")
            ->limit(10)
            ->offset(3)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM post ORDER BY id DESC LIMIT 10 OFFSET 3", $q);
    }

    public function testPage()
    {
        $q = $this->getBuilder()
            ->from("users")
            ->limit(10)
            ->page(3)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users ORDER BY id DESC LIMIT 10 OFFSET 20", $q);
        $q = $this->getBuilder()
            ->from("users")
            ->limit(10)
            ->page(1)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users ORDER BY id DESC LIMIT 10 OFFSET 0", $q);
    }

    public function testCondition()
    {
        $q = $this->getBuilder()
            ->from("users")
            ->where("id > :id")
            ->setParam("id", 3)
            ->limit(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users WHERE id > :id ORDER BY id DESC LIMIT 10", $q);
    }

    public function testSelect()
    {
        $q = $this->getBuilder()
            ->select("id", "name", "product")
            ->from("users");
        $this->assertEquals("SELECT id, name, product FROM users", $q->toSQL());
    }

    public function testSelectMultiple()
    {
        $q = $this->getBuilder()
            ->select("id", "name")
            ->from("users")
            ->select('product');
        $this->assertEquals("SELECT id, name, product FROM users", $q->toSQL());
    }

    public function testSelectAsArray()
    {
        $q = $this->getBuilder()
            ->select(["id", "name", "product"])
            ->from("users");
        $this->assertEquals("SELECT id, name, product FROM users", $q->toSQL());
    }

    public function testFetch()
    {
        $city = $this->getBuilder()
            ->from("post")
            ->where("name = :name")
            ->setParam("name", "Quo adipisci sequi amet provident.")
            ->fetch($this->getPDO() , "created_by");
        $this->assertEquals("Cavernos", $city);
    }

    public function testFetchWithInvalidRow()
    {
        $city = $this->getBuilder()
            ->from("post")
            ->where("name = :name")
            ->setParam("name", "azezaeeazazzaez")
            ->fetch($this->getPDO(), "created_by");
        $this->assertNull($city);
    }
    public function testCount()
    {
        $query = $this->getBuilder()
            ->from("post")
            ->where("name IN (:name1, :name2)")
            ->setParam("name1", "Magnam veritatis eum voluptatum ex placeat.")
            ->setParam("name2", "Corporis et ex fugit quia nemo labore aspernatur.");
        $this->assertEquals(2, $query->count($this->getPDO()));
    }

    /**
     * L'appel a count ne doit pas modifier les champs de la première requête
     */
    public function testBugCount()
    {
        $q = $this->getBuilder()->from("post");
        $this->assertEquals(50, $q->count($this->getPDO()));
        $this->assertEquals("SELECT * FROM post", $q->toSQL());
    }

}

