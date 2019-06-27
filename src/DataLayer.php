<?php

namespace CoffeeCode\DataLayer;

use PDO;
use PDOException;
use stdClass;

class DataLayer
{
    use CrudTrait;

    private $entity;
    private $primary;
    private $required;

    protected $statement;

    protected $params;
    protected $order;
    protected $limit;
    protected $offset;

    protected $fail;
    protected $data;

    public function __construct(string $entity, array $requiredFileds, string $primaryKey = 'id')
    {
        $this->entity = $entity;
        $this->primary = $primaryKey;
        $this->required = $requiredFileds;
    }

    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }

        $this->data->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    public function data(): ?object
    {
        return $this->data;
    }

    public function fail(): ?PDOException
    {
        return $this->fail;
    }

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

    public function findById(int $id, string $columns = "*"): ?DataLayer
    {
        $find = $this->find($this->primary . " = :id", "id={$id}", $columns);
        return $find->fetch();
    }

    public function order(string $columnOrder): ?DataLayer
    {
        $this->order = " ORDER BY {$columnOrder}";
        return $this;
    }

    public function limit(int $limit): ?DataLayer
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    public function offset(int $offset): ?DataLayer
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connect::getInstance()->prepare($this->statement . $this->order . $this->limit . $this->offset);
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

    public function count(): int
    {
        $stmt = Connect::getInstance()->prepare($this->statement);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    public function save(): bool
    {
        $id = null;
        $primary = $this->primary;

        try {
            if (!$this->required()) {
                throw new PDOException("Preencha os campos necessários");
            }

            /** Update */
            if (!empty($this->id)) {
                $id = $this->data->$primary;
                $this->update($this->safe(), $this->primary . " = :id", "id={$id}");
            }

            /** Create */
            if (empty($this->id)) {
                $id = $this->create($this->safe());
            }

            $this->data = $this->findById($id)->data();
            return true;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

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

    protected function safe(): ?array
    {
        $safe = (array)$this->data;
        foreach ([$this->primary, "updated_at", "created_at"] as $unset) {
            unset($safe[$unset]);
        }

        return $safe;
    }
}