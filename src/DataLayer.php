<?php

namespace CoffeeCode\DataLayer;

use Exception;
use PDO;
use PDOException;
use stdClass;

/**
 * Class DataLayer
 * @package CoffeeCode\DataLayer
 */
abstract class DataLayer
{
    use CrudTrait;

    /** @var string $entity database table */
    private $entity;

    /** @var string $primary table primary key field */
    private $primary;

    /** @var array $required table required fields */
    private $required;

    /** @var string $timestamps control created and updated at */
    private $timestamps;

    /** @var string */
    protected $statement;

    /** @var string */
    protected $params;

    /** @var string */
    protected $group;

    /** @var string */
    protected $order;

    /** @var int */
    protected $limit;

    /** @var int */
    protected $offset;

    /** @var \PDOException|null */
    protected $fail;

    /** @var object|null */
    protected $data;

    /** @var array */
    protected $join;

    /** @var array */
    protected $leftJoin;

    /** @var array */
    protected $rightJoin;

    /** @var array */
    protected $where;

    /**
     * DataLayer constructor.
     * @param string $entity
     * @param array $required
     * @param string $primary
     * @param bool $timestamps
     */
    public function __construct(string $entity, array $required, string $primary = 'id', bool $timestamps = true)
    {
        $this->entity = $entity;
        $this->primary = $primary;
        $this->required = $required;
        $this->timestamps = $timestamps;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     * @return string|null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @return object|null
     */
    public function data(): ?object
    {
        return $this->data;
    }

    /**
     * @return PDOException|Exception|null
     */
    public function fail()
    {
        return $this->fail;
    }

    /**
     * @param string|null $terms
     * @param string|null $params
     * @param string $columns
     * @return DataLayer
     */
    public function find(?string $terms = null, ?string $params = null, string $columns = "*"): DataLayer
    {
        if ($terms) {
            $this->statement = "SELECT {$columns} FROM {$this->entity} WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->statement = "SELECT {$columns} FROM {$this->entity}";
        return $this;
    }

    /**
     * @param int $id
     * @param string $columns
     * @return DataLayer|null
     */
    public function findById(int $id, string $columns = "*"): ?DataLayer
    {
        $find = $this->find($this->primary . " = :id", "id={$id}", $columns);
        return $find->fetch();
    }

    /**
     * for use with the new functions:
     * join(), leftJoin(), rightJoin(), where(), whereRaw(), whereIn()
     *
     * @param bool $all
     * @return null|array|mixed|DataLayer
     */
    public function get(bool $all = false)
    {
        $find = $this->find();
        return $find->fetch($all);
    }

    /**
     * @param string $column
     * @return DataLayer|null
     */
    public function group(string $column): ?DataLayer
    {
        $this->group = " GROUP BY {$column}";
        return $this;
    }

    /**
     * @param string $columnOrder
     * @return DataLayer|null
     */
    public function order(string $columnOrder): ?DataLayer
    {
        $this->order = " ORDER BY {$columnOrder}";
        return $this;
    }

    /**
     * @param int $limit
     * @return DataLayer|null
     */
    public function limit(int $limit): ?DataLayer
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    /**
     * @param int $offset
     * @return DataLayer|null
     */
    public function offset(int $offset): ?DataLayer
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    /**
     * @param string $table
     * @param mixed ...$args
     * @return DataLayer
     */
    public function join(string $table, ...$args): DataLayer
    {
        if (!$args[0] instanceof \Closure && $args[0] && $args[1]) {
            $this->join[] = " INNER JOIN {$table} ON ({$table}.{$args[0]} = {$this->entity}.{$args[1]}) ";
        }
        return $this;
    }

    /**
     * @param string $table
     * @param mixed ...$args
     * @return DataLayer
     */
    public function leftJoin(string $table, ...$args): DataLayer
    {
        if (!$args[0] instanceof \Closure && $args[0] && $args[1]) {
            $this->leftJoin[] = " LEFT OUTER JOIN {$table} ON ({$table}.{$args[0]} = {$this->entity}.{$args[1]}) ";
        }
        return $this;
    }

    /**
     * @param string $table
     * @param mixed ...$args
     * @return DataLayer
     */
    public function rightJoin(string $table, ...$args): DataLayer
    {
        if (!$args[0] instanceof \Closure && $args[0] && $args[1]) {
            $this->rightJoin[] = " RIGHT OUTER JOIN {$table} ON ({$table}.{$args[0]} = {$this->entity}.{$args[1]}) ";
        }
        return $this;
    }

    /**
     * @param string $whereRaw
     * @return DataLayer
     */
    public function whereRaw(string $whereRaw): DataLayer
    {
        $this->where[] = " {$whereRaw} ";
        return $this;
    }

    /**
     * @param string $field
     * @param array $values
     * @return DataLayer
     */
    public function whereIn(string $field, array $values = []): DataLayer
    {
        $this->where[] = " {$field} IN (" . implode(",", $values) . ")";
        return $this;
    }

    /**
     * @param string $field
     * @param string $operator
     * @param $value
     * @return DataLayer
     */
    public function where(string $field, string $operator, $value): DataLayer
    {
        $this->where[] = " {$field} {$operator} :" . str_replace(".", "_", $field);
        $params = "{$field}={$value}";
        $this->concatParams($params);
        parse_str($params, $this->params);
        return $this;
    }

    /**
     * @param string|null $params
     */
    private function concatParams(?string &$params): void
    {
        if ($this->params) {
            foreach ($this->params as $key => $value) {
                $params .= "&{$key}={$value}";
            }
        }
    }

    /**
     * clauseWhere
     * @return void
     */
    private function clauseWhere(): void
    {
        if ($this->where) {
            foreach ($this->where as $key => $value) {
                if (strpos($this->statement, "WHERE") === false) {
                    $this->statement .= " WHERE {$value} ";
                } else {
                    $this->statement .= " AND {$value} ";
                }
            }
        }
    }

    /**
     * clauseJoins
     * @return void
     */
    private function clauseJoins(): void
    {
        if ($this->join) {
            foreach ($this->join as $key => $value) {
                $this->statement .= $value;
            }
        }

        if ($this->leftJoin) {
            foreach ($this->leftJoin as $key => $value) {
                $this->statement .= $value;
            }
        }

        if ($this->rightJoin) {
            foreach ($this->rightJoin as $key => $value) {
                $this->statement .= $value;
            }
        }
    }

    /**
     * @param bool $all
     * @return array|mixed|null
     */
    public function fetch(bool $all = false)
    {
        try {

            $this->clauseJoins();
            $this->clauseWhere();

            $stmt = Connect::getInstance()->prepare($this->statement . $this->group . $this->order . $this->limit . $this->offset);
            $stmt->execute($this->params);

            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $stmt = Connect::getInstance()->prepare($this->statement);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $primary = $this->primary;
        $id = null;

        try {
            if (!$this->required()) {
                throw new Exception("Preencha os campos necessários");
            }

            /** Update */
            if (!empty($this->data->$primary)) {
                $id = $this->data->$primary;
                $this->update($this->safe(), $this->primary . " = :id", "id={$id}");
            }

            /** Create */
            if (empty($this->data->$primary)) {
                $id = $this->create($this->safe());
            }

            if (!$id) {
                return false;
            }

            $this->data = $this->findById($id)->data();
            return true;
        } catch (Exception $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        $primary = $this->primary;
        $id = $this->data->$primary;

        if (empty($id)) {
            return false;
        }

        $destroy = $this->delete($this->primary . " = :id", "id={$id}");
        return $destroy;
    }

    /**
     * @return bool
     */
    protected function required(): bool
    {
        $data = (array)$this->data();
        foreach ($this->required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array|null
     */
    protected function safe(): ?array
    {
        $safe = (array)$this->data;
        unset($safe[$this->primary]);

        return $safe;
    }
}
