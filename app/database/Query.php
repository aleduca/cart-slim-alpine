<?php
namespace app\database;

class Query
{
    private ?string $sql;
    private array $where = [];
    private array $binds = [];
    private array $joins = [];
    private ?string $limit;
    private ?string $order;
    private ?string $group;

    private function resetQuery()
    {
        if (!empty($this->sql)) {
            $this->sql = null;
        }
        if (!empty($this->where)) {
            $this->where = [];
        }
        if (!empty($this->binds)) {
            $this->binds = [];
        }
        if (!empty($this->joins)) {
            $this->joins = [];
        }
        if (!empty($this->limit)) {
            $this->limit = null;
        }
        if (!empty($this->order)) {
            $this->order = null;
        }
        if (!empty($this->group)) {
            $this->group = null;
        }
    }

    public function select(string $from, string $fields = '*')
    {
        $this->resetQuery();
        $this->sql = "select {$fields} from {$from}";
        return $this;
    }

    public function where(string $field, string $operator, string $value, ?string $logic = null)
    {
        if (str_contains($field, '.')) {
            $placeholder = str_replace('.', '', $field);
        }
        $query = "{$field} {$operator} :{$placeholder}";
        $query.= !empty($logic) ? ' '.$logic : '';
        $this->where[] = trim($query);
        $this->binds[$placeholder] = $value;

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

    public function join(string $table, string $relationship, string $type = 'inner')
    {
        // inner join categories c on p.id = c.product_id inner join categoryName cn on c.category_id = cn.id
        $this->joins[] = " {$type} join {$table} on {$relationship}";
        return $this;
    }

    public function group(string $group)
    {
        $this->group = " group by $group";
        return $this;
    }

    private function dump()
    {
        $this->sql.= (!empty($this->joins)) ? implode(' ', $this->joins): '';
        $this->sql.= (!empty($this->where)) ? ' where '.implode(' ', $this->where): '';
        $this->sql.= $this->order ?? '';
        $this->sql.= $this->limit ?? '';
        $this->sql.= $this->group ?? '';
        var_dump($this->sql);
        // die();
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
