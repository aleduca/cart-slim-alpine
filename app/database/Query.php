<?php
namespace app\database;

class Query
{
    private ?string $sql;
    private array $where = [];
    private array $binds = [];
    private ?string $limit;
    private ?string $order;

    public function select(string $from, string $fields = '*')
    {
        $this->sql = "select {$fields} from {$from}";
        return $this;
    }

    public function where(string $field, string $operator, string $value, string $logic = null)
    {
        $query = "{$field} {$operator} :{$field}";
        $query.= !empty($logic) ? ' '.$logic : '';
        $this->where[] = trim($query);
        $this->binds[$field] = $value;

        return $this;
    }
    
    public function limit(int $limit)
    {
        $this->limit = " limit {$limit}";
        return $this;
    }
    
    public function order(string $order)
    {
        $this->order = ' '.$order;
        return $this;
    }

    public function dump()
    {
        $this->sql.= (!empty($this->where)) ? ' where '.implode(' ', $this->where): '';
        $this->sql.= $this->order ?? '';
        $this->sql.= $this->limit ?? '';
        var_dump($this->sql);
    }

    public function get()
    {
        $this->dump();
        $connection = Connection::getConnection();

        $prepare = $connection->prepare($this->sql);
        $prepare->execute($this->binds ?? []);
        return $prepare->fetchAll();
    }


    public function first()
    {
        $this->dump();

        $connection = Connection::getConnection();

        $prepare = $connection->prepare($this->sql);
        $prepare->execute($this->binds ?? []);
        return $prepare->fetchObject();
    }
}
