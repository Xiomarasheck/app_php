<?php

class Department extends Model
{
    private $id;
    private $description;

    /**
     * Department constructor.
     * @param $adapter
     */
    public function __construct($adapter)
    {
        $table = "departamento";
        parent::__construct($table, $adapter);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     */
    public function getCity()
    {
        $query = "SELECT " .
            "  `id`," .
            "  `descripcion` " .
            " FROM" .
            "  `appprueba`." . $this->getTable() . " " .
            " WHERE `id_departamento` = '" . trim($this->getDepartmentId()) . "' " .
            "  AND `descripcion` = '" . trim($this->getDescription()) . "' ;";

        $data = $this->executeSql($query);
        return $data;
    }


    /**
     * @return bool|mysqli_result
     */
    public function save()
    {

        $query = "INSERT INTO " . $this->getTable() . " (id_departamento,descripcion)
                VALUES(
                       '" . trim($this->getDescription()) . "');";

        $save = $this->db()->query($query);

        return $save;
    }


}