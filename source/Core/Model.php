<?php

namespace Source\Core;

/**
 * CLASSE MODELO [ Layer Supertype Pattern e Active Record ]
 *
 * @author Luiz Paulo Escobal
 */
abstract class Model
{
    /** @var object|null  dados da classe stateless*/
    protected $data;

    /** @var \PDOException|null */
    protected $fail;

    /** @var string|null */
    protected $message;

    /** @var string */
    protected $query;

    /** @var string */
    protected $params;

    /** @var string $entity nome da tabela */
    protected $entity;

    /** @var array $protected não pode ser atualizado ou persistido */
    protected $protected;

    /** @var array $required database table */
    protected $required;

    /**
     * Model constructor.
     * @param string $entity Nome da tabela
     * @param array $protected colunas protegidas da tabela
     * @param array $required colunas not null da tabela
     */
    public function __construct(string $entity, array $protected, array $required)
    {
        $this->entity = $entity;
        $this->protected = array_merge($protected, ['created_at', "updated_at"]);
        $this->required = $required;
        $this->message = '';
    }

    /**
     * Método responsável por setar um dado na classe ativa
     * - stateless
     * 
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * Método responsável por verificar se existe um dado na classe ativa
     * - stateless
     * 
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * Método responsável por encontrar um dado na classe ativa
     * - stateless
     * 
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * Método responsável por retornar todos os dados da classe herdeira ativada/setada
     * 
     * @return null|object
     */
    public function data(): ?object
    {
        return $this->data;
    }

    /**
     * Método responsável por retornar erro de PDOException para debug
     * @return \PDOException
     */
    public function fail(): ?\PDOException
    {
        return $this->fail;
    }

    /**
     * Método responsável por retornar mensagem de erro da classe
     * 
     * @return string|null
     */
    public function message(): ?string
    {
        return $this->message;
    }

    /**
     * Método responsável por contruir o STMT para ser "fetchado" logo em seguida
     * 
     * @param null|string $terms
     * @param null|string $params
     * @param string $columns
     * @return Model|mixed
     */
    public function find(?string $terms = null, ?string $params = null, string $columns = "*")
    {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM " . $this->entity . " WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->query = "SELECT {$columns} FROM " . $this->entity;
        return $this;
    }

    /**
     * @param int $id
     * @param string $columns
     * @return null|mixed|Model
     */
    public function findById(?string $id, string $columns = "*"): ?Model
    {
        $find = $this->find("id = :id", "id={$id}", $columns);
        return $find->fetch();
    }

    /**
     * Método responsável por abstrair o fetch e fetchAll do PDO
     *  - Como se fosse uma "FACHADA"
     * 
     * @param bool $all
     * @return null|array|mixed|Model
     */
    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connect::getInstance()->prepare($this->query . $this->order . $this->limit . $this->offset);
            $stmt->execute($this->params);

            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Método CREATE do CRUD da superclasse de abstração
     * 
     * @param array $data
     * @return int|null
     */
    protected function create(array $data): ?int
    {

        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance()->prepare("INSERT INTO " . $this->entity . " ({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data));


            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Método UPDATE do CRUD da superclasse de abstração
     * 
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    protected function update(array $data, string $terms, string $params): ?int
    {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = Connect::getInstance()->prepare("UPDATE " . $this->entity . " SET {$dateSet} WHERE {$terms}");
            $stmt->execute($this->filter(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Método responsável pela automatização da atualização e persistencia da classe herdeira, utilizando-se_
     *  das qualidades do pattern ACTIVE RECORD
     * 
     * @return bool
     */
    public function save(): bool
    {

        if (!$this->required()) {
            $this->message = "Preencha todos os campos para continuar";
            return false;
        }


        /** Update */
        if (!empty($this->id)) {
            $id = $this->id;
            $this->update($this->safe(), "id = :id", "id={$id}");
            if ($this->fail()) {
                $this->message = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** Create */
        if (empty($this->id)) {
            $id = $this->create($this->safe());
            if ($this->fail()) {
                $this->message = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = $this->findById($id)->data();
        return true;
    }

    /**
     * Método DELETE do CRUD da superclasse de abstração
     * 
     * @param string $terms
     * @param null|string $params
     * @return bool
     */
    protected function delete(string $terms, ?string $params): bool
    {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM " . $this->entity . " WHERE {$terms}");
            if ($params) {
                parse_str($params, $params);
                /** @var array $params */
                $stmt->execute($params);
                return true;
            }

            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * Método responsável por remover uma linha no DB do modelo herdeiro
     * - Essa é um método que incomum que pode ser reutilizado
     * 
     * @return bool
     */
    public function destroy(): bool
    {
        if (empty($this->id)) {
            return false;
        }

        $destroy = $this->delete("id = :id", "id={$this->id}");
        return $destroy;
    }

    /**
     * Método responsável "unsetar" da classe herdeira os dados que não podem ser atualizados ou criados_
     *  ou seja id, created_at, updated_at, dados que tem manipulação automatica no banco
     * 
     * @return array|null
     */
    protected function safe(): ?array
    {
        $safe = (array)$this->data;
        foreach ($this->protected as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }

    /**
     * Método responsável por filtrar|sanitizar os dados passados para o modelo que herda a classe
     * 
     * @param array $data
     * @return array|null
     */
    private function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }
        return $filter;
    }

    /**
     * Método responsável por validar as colunas obrigatórios no tabela
     * 
     * @return bool
     */
    protected function required(): bool
    {
        $data = (array)$this->data();
        foreach ($this->required as $field) {
            if (empty($data[$field]) && !($data[$field] !== '0' || $data[$field] !== 0)) {
                return false;
            }
        }
        return true;
    }
}