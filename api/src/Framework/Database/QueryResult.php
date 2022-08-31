<?php
namespace cavernos\bascode_api\Framework\Database;

use ArrayAccess;
use Exception;
use Iterator;

class QueryResult implements ArrayAccess, Iterator
{
    
    /**
     * records
     *
     * @var array
     */
    private $records;
    
    /**
     * index
     *
     * @var int
     */
    private $index = 0;

    private $entity;

    /**
     * hydratedRecords
     *
     * @var array
     */
    private $hydratedRecords = [];
    
    public function __construct(array $records, ?string $entity = null)
    {
        $this->records = $records;
        $this->entity = $entity;
    }

    public function get(int $index)
    {
        if ($this->entity) {
            if (!isset($this->hydratedRecords[$index])) {
                $this->hydratedRecords[$index] =  Hydrator::hydrate($this->records[$index], $this->entity);
            }
            return $this->hydratedRecords[$index];
        }
        return $this->entity;
    }

     /**
     * offsetExists
     *
     * @param  mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->records[$offset]);
    }
    
    /**
     * offsetGet
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }
    
    /**
     * offsetSet
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @throws Exception
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new Exception("Il n'est pas possible de modifier un enregistrement");
    }
    
    /**
     * offsetUnset
     *
     * @param  mixed $offset
     * @throws Exception
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new Exception("Il n'est pas possible de modifier un enregistrement");
    }
    
    /**
     * current
     *
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->get($this->index);
    }
    
    /**
     * next
     *
     * @return void
     */
    public function next(): void
    {
        $this->index++;
    }
        
    /**
     * key
     *
     * @return mixed
     */
    public function key(): mixed
    {
        return $this->index;
    }
    
    /**
     * valid
     *
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->records[$this->index]);
    }
    
    /**
     * rewind
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->index = 0;
    }
}
