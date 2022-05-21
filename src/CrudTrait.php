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
    protected function create(array $data): ?int
    {
        if ($this->timestamps) {
            $data["created_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
            $data["updated_at"] = $data["created_at"];
        }

        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            if ($this->encryptSecretKey && $this->encrypt) {
                $values = [];
                foreach (array_keys($data) as $value) {
                    if (in_array($value, $this->encrypt)) {
                        $values[] = "AES_ENCRYPT(:$value, UNHEX(SHA2('$this->encryptSecretKey', 512)))";
                    } else {
                        $values[] = ":$value";
                    }
                }
                $values = implode(", ", $values);
            }

            $stmt = Connect::getInstance($this->database);
            $prepare = $stmt->prepare("INSERT INTO {$this->entity} ({$columns}) VALUES ({$values})");
            $prepare->execute($this->filter($data));

            return $stmt->lastInsertId();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
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
            $dataSet = [];
            foreach ($data as $bind => $value) {
                if (in_array($bind, $this->encrypt)) {
                    $dataSet[] = "{$bind} = AES_ENCRYPT(:$bind, UNHEX(SHA2('$this->encryptSecretKey', 512)))";
                } else {
                    $dataSet[] = "{$bind} = :{$bind}";
                }
            }
            $dataSet = implode(", ", $dataSet);
            parse_str($params, $params);

            $stmt = Connect::getInstance($this->database);
            $prepare = $stmt->prepare("UPDATE {$this->entity} SET {$dataSet} WHERE {$terms}");
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