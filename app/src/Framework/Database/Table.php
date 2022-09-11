<?php
namespace cavernos\bascode_api\Framework\Database;

use Exception;
use Pagerfanta\Pagerfanta;
use PDO;
use stdClass;

class Table
{
    
    /**
     * pdo
     *
     * @var PDO
     */
    private $pdo;
    
    /**
     * Nom de la table en Bdd
     *
     * @var ?string
     */
    protected $table;
    
    /**
     * entité à utiliser
     *
     * @var string
     */
    protected $entity = stdClass::class;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
       

    
    /**
     * find Récupère un élément à partir de son id
     *
     * @param  int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->makeQuery()->where("id = $id")->fetchOrFail();
    }

    public function makeQuery(): Query
    {
        return (new Query($this->pdo))
        ->from($this->table, $this->table[0])
        ->into($this->entity);
    }
    
    /**
     * findList Récupère une liste clé valeur de nos enregistrement
     *
     * @return array
     */
    public function findList(): array
    {
        $results = $this->pdo->query("SELECT * FROM $this->table")
        ->fetchAll(PDO::FETCH_NUM);
        $list = [];
        foreach ($results as $result) {
            $list[$result[0]] = $result[1];
        }
        return $list;
    }

    public function findAll(): QueryResult
    {
        return $this->makeQuery()->fetchAll();
    }
    
    /**
     * findBy
     *
     * @param  string $field
     * @param  string $value
     * @return mixed
     */
    public function findBy(string $field, string $value): mixed
    {
        return $this->makeQuery()->where("$field = :field")->params(['field' => $value])->fetchOrFail();
    }
    
    /**
     * count
     *
     * @return bool
     */
    public function count(): int
    {
        return $this->makeQuery()->count();
    }
    
    /**
     * update met à jour un enregistrement dans la db
     *
     * @param  int $id
     * @param  array $params
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params["id"] = $id;
        $statement = $this->pdo->prepare("UPDATE $this->table SET $fieldQuery WHERE id = :id");
        return $statement->execute($params);
    }

    /**
     * update met à jour un enregistrement dans la db
     *
     * @param  array $params
     * @param ?bool $result
     * @return bool
     */
    public function insert(array $params, ?bool $result = null): bool
    {
        $fields = array_keys($params);
        $values =  join(', ', array_map(function ($field) {
            return ':' . $field;
        }, $fields));
        $fields = join(', ', $fields);
        $statement = $this->pdo->prepare("INSERT INTO $this->table ($fields) VALUES ($values)");
        if ($result) {
            $statement->execute($params);
            return $statement->fetch();
        }
        return $statement->execute($params);
    }
    
    /**
     * delete supprime un enregistrement
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id = ?");
        return $statement->execute([$id]);
    }
    
    /**
     * buildFieldQuery
     *
     * @param  array $params
     * @return string
     */
    private function buildFieldQuery(array $params): string
    {
        return  join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }

    /**
     * Get nom de la table en Bdd
     *
     * @return  string
     */
    public function getTable():string
    {
        return $this->table;
    }

    /**
     * Get entité à utiliser
     *
     * @return  string
     */
    public function getEntity():string
    {
        return $this->entity;
    }

    /**
     * Get pdo
     *
     * @return  PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}
