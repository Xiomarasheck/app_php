<?php

require_once __DIR__ . '/../Controllers/Class/Connection.php';

class Model
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var mysqli
     */
    private $db;

    /**
     * @var Connection
     */
    private $connection;

    public function __construct($table, $adapter)
    {
        $this->table = (string)$table;

        /*
        require_once 'Conectar.php';
        $this->conectar=new Conectar();
        $this->db=$this->conectar->conexion();
         */
        $this->connection = null;
        $this->db = $adapter;


    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return mysqli
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mysqli $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }


    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return mysqli
     */
    public function db()
    {
        return $this->db;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $resultSet = [];
        $query = $this->db->query("SELECT * FROM $this->table ORDER BY id DESC");

        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }

    /**
     * @param $id
     * @return object|stdClass
     */
    public function getById($id)
    {
        $resultSet = [];
        $query = $this->db->query("SELECT * FROM $this->table WHERE id=$id");

        if ($row = $query->fetch_object()) {
            $resultSet = $row;
        }

        return $resultSet;
    }

    /**
     * @param $column
     * @param $value
     * @return array
     */
    public function getBy($column, $value)
    {
        $resultSet = [];
        $query = $this->db->query("SELECT * FROM $this->table WHERE $column='$value'");

        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }

    /**
     * @param $id
     * @return bool|mysqli_result
     */
    public function deleteById($id)
    {
        $query = $this->db->query("DELETE FROM $this->table WHERE id=$id");
        return $query;
    }

    /**
     * @param $column
     * @param $value
     * @return bool|mysqli_result
     */
    public function deleteBy($column, $value)
    {
        $query = $this->db->query("DELETE FROM $this->table WHERE $column='$value'");
        return $query;
    }


    public function executeSql($query)
    {

        $resultSet = [];
        $query = $this->db()->query($query);
        if ($query == true) {
            if ($query->num_rows > 1) {
                while ($row = $query->fetch_object()) {
                    $resultSet[] = $row;
                }
            } elseif ($query->num_rows == 1) {
                if ($row = $query->fetch_object()) {
                    $resultSet = $row;
                }
            } else {
                $resultSet = true;
            }
        } else {
            $resultSet = false;
        }

        return $resultSet;
    }

}

?>