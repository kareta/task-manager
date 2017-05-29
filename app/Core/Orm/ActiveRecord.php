<?php

namespace Core\Orm;


use Core\Application;
use Core\Exceptions\NotFoundException;
use PDO;

abstract class ActiveRecord
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var PDO
     */
    protected static $connection;

    /**
     * ActiveRecord constructor.
     */
    function __construct()
    {
        $this->config = require ROOT_DIR . '/config/config.php';
    }

    /**
     * @return PDO
     */
    protected static function getConnection()
    {
        if (self::$connection != null) {
            return self::$connection;
        }

        $database = Application::$config['db']['database'];
        $host = Application::$config['db']['host'];
        $username = Application::$config['db']['username'];
        $password = Application::$config['db']['password'];

        self::$connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        self::$connection->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        return self::$connection;
    }


    /**
     * @param string $query
     * @param array $bindings
     * @return array
     */
    public static function select($query = '', $bindings = [])
    {
        $instance = new static;
        $connection = $instance->getConnection();

        $query = "SELECT * FROM {$instance->table} " . $query;
        $statement = $connection->prepare($query);

        $statement->execute($bindings);
        $resultSet = $statement->fetchAll();

        $entities = [];
        foreach ($resultSet as $entityAttributes) {
            $entity = new static;
            $entity->attributes = $entityAttributes;
            $entities[] = $entity;
        }
        return $entities;
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return int
     */
    public static function count($query = '', $bindings = [])
    {
        $instance = new static;
        $connection = $instance->getConnection();

        $query = "SELECT count(*) FROM {$instance->table} " . $query;
        $statement = $connection->prepare($query);

        $statement->execute($bindings);
        $resultSet = $statement->fetchAll();

        if (empty($resultSet) || !isset($resultSet[0][0])) {
            return 0;
        }

        $count = $resultSet[0][0];

        return $count;
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return ActiveRecord|null
     */
    public static function selectFirst($query = '', $bindings = [])
    {
        $entities = self::select($query, $bindings);
        if (count($entities) > 0) {
            return $entities[0];
        }

        return null;
    }

    /**
     * @return array
     */
    public static function all()
    {
        return self::select();
    }

    /**
     * @param $id
     * @return ActiveRecord|null
     */
    public static function get($id)
    {
        $instance = new static;
        return self::selectFirst("WHERE {$instance->primaryKey} = :id", [':id' => $id]);
    }

    /**
     * @param $id
     * @return ActiveRecord|null
     * @throws NotFoundException
     */
    public static function getOrFail($id)
    {
        $instance = new static;
        $model = self::selectFirst("WHERE {$instance->primaryKey} = :id", [':id' => $id]);

        if (!$model) {
            throw new NotFoundException('Model not found');
        }

        return $model;
    }

    protected function update()
    {
        $connection = $this->getConnection();

        $query = "UPDATE {$this->table} SET ";

        $bindings = [];
        foreach ($this->attributes as $name => $value) {
            if (is_int($name) || $name == $this->primaryKey) {
                continue;
            }

            $query .=  "$name = :$name, ";
            $bindings[":$name"] = $value;
        }

        $query = rtrim($query, ', ');

        $bindings[':id'] = $this->attributes[$this->primaryKey];
        $query .= " WHERE {$this->primaryKey} = :id";
        $statement = $connection->prepare($query);
        $statement->execute($bindings);
    }

    protected function insert()
    {
        $connection = $this->getConnection();

        $query = "INSERT INTO {$this->table} ";

        $bindings = [];
        $names = '(';
        $values = '(';
        foreach ($this->attributes as $name => $value) {
            $names .= "$name, ";
            $values .= ":$name, ";
            $bindings[":$name"] = $value;
        }

        $names = rtrim($names, ', ');
        $names .= ') ';

        $values = rtrim($values, ', ');
        $values .= ') ';

        $query .= $names . ' VALUES ' . $values;

        $statement = $connection->prepare($query);
        $statement->execute($bindings);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        if (!isset($this->attributes[$this->primaryKey])) {
            return false;
        }

        $entity = self::get($this->attributes[$this->primaryKey]);

        return $entity != null;
    }

    public function save()
    {
        if ($this->exists()) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function delete()
    {
        self::destroy($this->attributes[$this->primaryKey]);
    }

    /**
     * @param $id
     */
    public static function destroy($id)
    {
        $instance = new static;

        $connection = $instance->getConnection();
        $query = "DELETE FROM {$instance->table} WHERE {$instance->primaryKey} = :id";

        $statement = $connection->prepare($query);
        $statement->execute([':id' => $id]);
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        } else {
            throw new \Exception('No such property: ' . $name);
        }
    }

    /**
     * @param string $name
     * @param string $value
     */
    function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param string $name
     * @return bool
     */
    function __isset($name) {
        return array_key_exists($name, $this->attributes);
    }
}