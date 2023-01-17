<?php

namespace CoffeeCode\DataLayer;

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
    private string $entity;

    /** @var string $primary table primary key field */
    private string $primary;

    /** @var array $required table required fields */
    private array $required;

    /** @var bool $timestamps control created and updated at */
    private bool $timestamps;

    /** @var array|null */
    private ?array $database;

    /** @var string|null */
    protected ?string $statement = null;

    /** @var array|null */
    protected ?array $params = null;

    /** @var string|null */
    protected ?string $group = null;

    /** @var string|null */
    protected ?string $order = null;

    /** @var string|null */
    protected ?string $limit = null;

    /** @var string|null */
    protected ?string $offset = null;

    /** @var PDOException|null */
    protected ?PDOException $fail = null;

    /** @var object|null */
    protected ?object $data = null;

    /**
     * DataLayer constructor.
     * @param string $entity
     * @param array $required
     * @param string $primary
     * @param bool $timestamps
     */
    public function __construct(
        string $entity,
        array $required,
        string $primary = 'id',
        bool $timestamps = true,
        array $database = null
    ) {
        $this->entity = $entity;
        $this->primary = $primary;
        $this->required = $required;
        $this->timestamps = $timestamps;
        $this->database = $database;
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
        $method = $this->toCamelCase($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return ($this->data->$name ?? null);
    }

    /**
     * @param int $mode
     * @return array|null
     */
    public function columns(int $mode = PDO::FETCH_OBJ): ?array
    {
        $stmt = Connect::getInstance($this->database)->prepare("DESCRIBE {$this->entity}");
        $stmt->execute($this->params);
        return $stmt->fetchAll($mode);
    }


    /**
     * @return object|null
     */
    public function data(): ?object
    {
        return $this->data;
    }

    /**
     * @return PDOException|null
     */
    public function fail(): ?PDOException
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
            parse_str($params ?? "", $this->params);
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
        return $this->find("{$this->primary} = :id", "id={$id}", $columns)->fetch();
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
     * @param string $column
     * @param array $values
     * @return DataLayer
     */
    public function in(string $column, array $values): DataLayer
    {
        $index = 0;
        $params = array();
        $statement = "{$column} IN (";

        foreach ($values as $value) {
            $index++;
            if ($value == end($values)) {
                $statement .= ":in_{$index}";
            } else {
                $statement .= ":in_{$index},";
            }

            $params["in_{$index}"] = $value;
        }

        $statement .= ")";
        if (!str_contains($this->statement, "WHERE")) {
            $this->statement .= " WHERE " . $statement;
        } else {
            $this->statement .= " AND " . $statement;
        }

        $this->params = $this->params ? $this->params += $params : $params;
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
     * @param bool $all
     * @return static|array|null
     */
    public function fetch(bool $all = false): array|static|null
    {
        try {
            $stmt = Connect::getInstance($this->database)->prepare(
                $this->statement . $this->group . $this->order . $this->limit . $this->offset
            );
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
        $stmt = Connect::getInstance($this->database)->prepare($this->statement);
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
        $save = null;

        try {
            if (!$this->required()) {
                throw new PDOException("Preencha os campos necessários");
            }

            /** Update */
            if (!empty($this->data->$primary)) {
                $id = $this->data->$primary;
                $save = $this->update($this->safe(), "{$this->primary} = :id", "id={$id}");
            }

            /** Create */
            if (empty($this->data->$primary)) {
                $id = $this->create($this->safe());
                $save = $id;
            }

            if ($save === false) {
                return false;
            }

            $this->data = $this->findById($id)->data();
            return true;
        } catch (PDOException $exception) {
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

        return $this->delete("{$this->primary} = :id", "id={$id}");
    }

    /**
     * @return bool
     */
    protected function required(): bool
    {
        $data = (array)$this->data();
        foreach ($this->required as $field) {
            if (empty($data[$field])) {
                if (!is_int($data[$field])) {
                    return false;
                }
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


    /**
     * @param string $string
     * @return string
     */
    protected function toCamelCase(string $string): string
    {
        $camelCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        $camelCase[0] = strtolower($camelCase[0]);
        return $camelCase;
    }
}
