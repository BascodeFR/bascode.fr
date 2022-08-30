<?php
namespace cavernos\bascode_api\Framework\Database;

use Exception;
use Pagerfanta\Pagerfanta;
use PDO;

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
    protected $entity;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
       
    /**
     * findPaginated Pagine les éléments
     *
     * @param  int $perPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            $this->paginationQuery(),
            "SELECT COUNT(id) FROM $this->table",
            $this->entity
        );
        return (new Pagerfanta($query))
        ->setMaxPerPage($perPage)
        ->setCurrentPage($currentPage);
    }

    protected function paginationQuery()
    {
        return "SELECT * FROM $this->table";
    }
    
    /**
     * find Récupère un élément à partir de son id
     *
     * @param  int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $query->execute(['id' => $id]);
        if ($this->entity) {
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        }
        return $query->fetch() ?: null;
    }
    
    /**
     * findList Récupère une liste clé valeur de nos enregistrement
     *
     * @return array
     */
    public function findList(): array
    {
        $results = $this->pdo->query("SELECT id, name FROM $this->table")
        ->fetchAll(PDO::FETCH_NUM);
        $list = [];
        foreach ($results as $result) {
            $list[$result[0]] = $result[1];
        }
        return $list;
    }
    
    /**
     * count
     *
     * @return bool
     */
    public function count(): int
    {
        return $this->fetchColumn("SELECT COUNT(id) FROM $this->table");
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
     * @param  int $id
     * @param  array $params
     * @return bool
     */
    public function insert(array $params): bool
    {
        $fields = array_keys($params);
        $values =  join(', ', array_map(function ($field) {
            return ':' . $field;
        }, $fields));
        $fields = join(', ', $fields);
        $statement = $this->pdo->prepare("INSERT INTO $this->table ($fields) VALUES ($values)");
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
    
    /**
     * fetchOrFail
     *
     * @param  string $query
     * @param  mixed $params
     * @return array
     */
    private function fetchOrFail(string $query, array $params = []): array
    {
        $query = $this->pdo->prepare($query);
        $query->execute($params);
        if ($this->entity) {
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        }
        $record = $query->fetch();
        if ($record === false) {
            throw new NoRecordException();
        }
        return $record;
    }
    
    /**
     * fetchColumn
     *
     * @param  string $query
     * @param  array $params
     * @return mixed
     */
    private function fetchColumn(string $query, array $params = [])
    {
        $query = $this->pdo->prepare($query);
        $query->execute($params);
        if ($this->entity) {
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        }
        return $query->fetchColumn();
    }
}
