<?php

namespace Framework;

class Model
{
    /**
     * Database instance
     * 
     * @var \Framework\Database
     */
    protected $database;

    /**
     * Table name
     * 
     * @var string
     */
    protected $table;

    /**
     * Model attributes
     * 
     * @var array
     */
    protected $attributes = [];

    /**
     * Constructor 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->setDatabase(Database::getInstance()->getConnection());
    }

    /**
     * Get table name for the model.
     * 
     * @return string
     */
    public function getTable()
    {
        if (!isset($this->table)) {
            throw new \Exception(sprintf('Table name doesn\'t exists in %s.', get_called_class()));
        }

        return $this->table;
    }

    /**
     * Set database
     * 
     * @param \Framework\Database $database
     * 
     * @return void
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    public function query($sql)
    {
        $statement = $this->database->prepare($sql);

        try {
            $result = $statement->execute();
            if (!$result) {
                throw new \Exception(sprintf('Invalid SQL statement.'));
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }

    public function setAttributes($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function create($attributes)
    {
        $this->setAttributes($attributes);

        // Example: 
        // $attributes = ['name' => 'John Doe', 'email' => 'john.doe@example.com']
        // $columns = 'name, email'
        // $values = 'John Doe, john.doe@example.com'
        $columns = implode(', ', array_keys($this->attributes));

        $values = '';
        $fields = array_keys($this->attributes);
        $last_key = end($fields);
        foreach ($this->attributes as $key => $value) {
            if (is_int($value)) {
                $values .= $value;
            } else {
                $values .= "'" . $value . "'";
            }

            if ($key != $last_key) {
                $values .= ",";
            }
        }

        $sql = "INSERT INTO " . $this->getTable() . "(" . $columns . ") VALUES(" . $values . ")";

        $statement = $this->database->prepare($sql);
        $result = $statement->execute();

        if (!$result) {
            throw new \Exception(sprintf('Wrong SQL Statement.'));
        }

        return $result;
    }

    public function fetch($column = '*', $orderBy = 'id')
    {
        $sql = "SELECT " . $column . " FROM " . $this->getTable() . ' ORDER BY ' . $orderBy;

        $statement = $this->database->prepare($sql);
        $result = $statement->execute();
        if (!$result) {
            throw new \Exception(sprintf('Wrong SQL Statement.'));
        }

        return $statement->fetchAll();
    }

    public function update($id, $attributes = [])
    {
        $data = [];
        $setter = [];
        // UPDATE users SET column = value WHERE id = id
        $this->setAttributes($attributes);
        foreach ($this->attributes as $column => $value) {
            $data[$column] = $value;
            $setter[] = $column . '=:' . $column;
        }
        $set = implode(', ', $setter);
        $sql = "UPDATE " . $this->getTable() . " SET " . $set . " WHERE id = " . $id;

        $statement = $this->database->prepare($sql);
        $result = $statement->execute($data);

        if (!$result) {
            throw new \Exception(sprintf('Wrong SQL Statement.'));
        }

        return $result;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->getTable() . " WHERE id=" . $id;
        $statement = $this->database->prepare($sql);
        $result = $statement->execute();

        if (!$result) {
            throw new \Exception(sprintf('Wrong SQL Statement'));
        }

        return $result;
    }

    public function get($id)
    {
        $sql = "SELECT * FROM " . $this->getTable() . " WHERE id = " . $id;
        $statement = $this->database->prepare($sql);
        $result = $statement->execute();

        if (!$result) {
            throw new \Exception(sprintf('Wrong SQL Statement'));
        }

        return $statement->fetch();
    }

    public function where($columns = [])
    {
        $data = [];
        $where = [];
        foreach ($columns as $column => $value) {
            $data[$column] = $value;
            $where[] = $column . "=:" . $column;
        }
        $where = implode(', ', $where);

        $sql = "SELECT * FROM " . $this->getTable() . " WHERE " . $where;

        $statement = $this->database->prepare($sql);
        $result = $statement->execute($data);

        if (!$result) {
            throw new \Exception(sprintf('Wrong SQL Statement'));
        }

        // \PDO::FETCH_ASSOC = field names
        // \PDO::FETCH_NUM = field number
        // \PDO::FETCH_OBJ = object
        // \PDO::FETCH_BOTH = field names & number (default)
        return $statement->fetchAll();
    }

    public function search($columns = [])
    {
        $data = [];
        $where = [];
        foreach ($columns as $column => $value) {
            $data[$column] = "%" . $value . "%";
            $where[] = $column . " LIKE :" . $column . "";
        }
        $where = implode('AND ', $where);

        $sql = "SELECT * FROM " . $this->getTable() . " WHERE " . $where;
        dump($sql);

        $statement = $this->database->prepare($sql);
        $result = $statement->execute($data);

        if (!$result) {
            throw new \Exception(sprintf('Wrong SQL Statement'));
        }

        return $statement->fetchAll();
    }
}
