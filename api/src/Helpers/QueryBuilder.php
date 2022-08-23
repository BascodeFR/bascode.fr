<?php
namespace cavernos\bascode_api\Helpers;

use PDO;

/**
 * QueryBuilder est une classe qui permet de générer des requête SQL
 *
 * @package cavernos\bascode_api\Helpers
 * @author Cavernos <louisdescavernes@gmail.com>
 * @version 1.0
 * @access private
 *
 */
class QueryBuilder
{

    
    /**
     * from
     *
     * @var string
     */
    private $from;
    /**
     * order
     *
     * @var array
     */
    private $order = [];
    
    /**
     * limit
     *
     * @var int
     */
    private $limit;

    /**
     * offset
     *
     * @var int
     */
    private $offset;


    /**
     * where
     *
     * @var string
     */
    private $where;

    /**
     * fields
     *
     * @var array
     */
    private $fields = ["*"];

    /**
     * params
     *
     * @var array
     */
    private $params = [];
    
    /**
     * from génère la requête SQL SELECT * FROM
     *
     * @param  string $table
     * @param  string $alias
     * @return self
     */
    public function from(string $table, string $alias = null) : self
    {
        $this->from = $alias === null ? $table : "$table $alias";
        return $this;
    }
    
    /**
     * orderBy génère la requête SQL ORDER BY
     *
     * @param  string $key
     * @param  string $direction
     * @return self
     */
    public function orderBy(string  $key, string $direction): self
    {
        $direction =strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $this->order[] = $key;
        } else {
            $this->order[] = "$key $direction";
        }
        return $this;
    }
    
    /**
     * limit génère la requète SQL LIMIT 1
     *
     * @param  int $limit
     * @return self
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * offset génère la requète SQL OFFSET 1
     *
     * @param  int $limit
     * @return self
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }
    
    /**
     * page génère la requète SQL pour afficher les données d'une page particulière
     *
     * @param  int $page
     * @return self
     */
    public function page(int $page): self
    {
        return $this->offset($this->limit * ($page - 1));
    }
    
    /**
     * where génère la requête SQL WHERE
     *
     * @param  string $where
     * @return self
     */
    public function where(string $where): self
    {
        $this->where = $where;
        return $this;
    }
    
    /**
     * setParam permet de passer des paramètre dans les requête préparé
     *
     * @param  string $key
     * @param  mixed $value
     * @return self
     */
    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }
    
    /**
     * select génère la requête SQL SELECT
     *
     * @param  mixed $fields
     * @return self
     */
    public function select(...$fields): self
    {
        if (is_array($fields[0])) {
            $fields = $fields[0];
        }
        if ($this->fields === ["*"]) {
            $this->fields = $fields;
        } else {
            $this->fields = array_merge($this->fields, $fields);
        }
        return $this;
    }
    
    /**
     * toSQL génère la requête SQL finale
     *
     * @return string
     */
    public function toSQL(): string
    {
        $fields = implode(', ', $this->fields);
        $sql = "SELECT $fields FROM {$this->from}";
        if ($this->where) {
            $sql .= " WHERE " .$this->where;
        }
        if (!empty($this->order)) {
            $sql .= " ORDER BY " . implode(', ', $this->order);
        }
        if ($this->limit > 0) {
            $sql .= " LIMIT " .$this->limit;
        }
        if ($this->offset !== null) {
            $sql .= " OFFSET " .$this->offset;
        }
        return $sql;
    }
    
    /**
     * fetch permet de récupérer des données en fonction du champs
     *
     * @param  PDO $pdo
     * @param  string $field
     * @return ?string
     */
    public function fetch(PDO $pdo, string $field): ?string
    {
        $query = $pdo->prepare($this->toSQL());
        $query->execute($this->params);
        $result = $query->fetch();
        if ($result === false) {
            return null;
        }
        return $result[$field] ?? null;
    }
    
    /**
     * count
     *
     * @param  PDO $pdo
     * @return int
     */
    public function count(PDO $pdo): int
    {
        $query = clone $this;
        return (int)$query->select('COUNT(id) count')->fetch($pdo, 'count');
        ;
    }
}
