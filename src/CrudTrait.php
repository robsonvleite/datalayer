<?php

namespace CoffeeCode\DataLayer;

use DateTime;
use PDOException;

/**
 * Trait CrudTrait
 * @package CoffeeCode\DataLayer
 */
trait CrudTrait
{
    /**
     * @param array $data
     * @return int|null
     * @throws PDOException
     */
    protected function create(array $data): string|bool
    {
        if ($this->timestamps) {
            $data["created_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
        }

        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance($this->database);
            $prepare = $stmt->prepare("INSERT INTO {$this->entity} ({$columns}) VALUES ({$values})");
            $prepare->execute($this->filter($data));

            return $stmt->lastInsertId();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     * @throws PDOException
     */
    protected function update(array $data, string $terms, string $params): ?int
    {
        if ($this->timestamps) {
            $data["updated_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
        }

        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params ?? "", $params);

            $stmt = Connect::getInstance($this->database);
            $prepare = $stmt->prepare("UPDATE {$this->entity} SET {$dateSet} WHERE {$terms}");
            $prepare->execute($this->filter(array_merge($data, $params)));

            return $prepare->rowCount();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $terms
     * @param string|null $params
     * @return bool
     */
    public function delete(string $terms, ?string $params): bool
    {
        try {
            $stmt = Connect::getInstance($this->database);
            $prepare = $stmt->prepare("DELETE FROM {$this->entity} WHERE {$terms}");
            if ($params) {
                parse_str($params, $params);
                $prepare->execute($params);
                return true;
            }

            $prepare->execute();
            return true;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * @param array $data
     * @return array|null
     */
    private function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filter;
    }
}
