<?php


namespace App\Db;


abstract class Modelo
{
    protected $data;
    protected $query;
    protected $params;
    protected $tabela;
    protected $protected;

    public function __construct(string $tabela, array $protected)
    {
        $this->tabela = $tabela;
        $this->protected = array_merge($protected, ['created_at', "updated_at"]);
    }

    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
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

    public function create(array $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Conexao::getInstancia()->prepare("INSERT INTO {$this->tabela} ({$columns}) VALUES ({$values})");
            $stmt->execute($this->sanitize($data));

            return Conexao::getInstancia()->lastInsertId();
        } catch (\PDOException $exception) {
            //var_dump($exception->getMessage());
            return null;
        }
    }

    public function read(?string $terms = null, ?string $params = null, string $columns = "*")
    {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM {$this->tabela} WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->query = "SELECT {$columns} FROM {$this->tabela}";
        return $this;
    }

    public function update(array $data, string $terms, string $params)
    {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = Conexao::getInstancia()->prepare("UPDATE {$this->tabela} SET {$dateSet} WHERE {$terms}");
            $stmt->execute($this->sanitize(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            return null;
        }
    }

    public function delete(string $terms, ?string $params): bool
    {
        try {
            $stmt = Conexao::getInstancia()->prepare("DELETE FROM {$this->tabela} WHERE {$terms}");
            if ($params) {
                parse_str($params, $params);
                $stmt->execute($params);
                return true;
            }

            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            var_dump($exception);
            return false;
        }
    }

    public function fetch(bool $all = false)
    {
        try {
            $stmt = Conexao::getInstancia()->prepare($this->query);
            $stmt->execute($this->params);

            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (\PDOException $exception) {
            return null;
        }
    }

    private function sanitize(array $data)
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filter;
    }

    protected function safe()
    {
        $safe = (array)$this->data;
        foreach ($this->protected as $unset) {
            unset($safe[$unset]);
        }

        return $safe;
    }
}