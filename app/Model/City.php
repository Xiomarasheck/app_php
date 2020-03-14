<?php

class City extends Model
{
    private $id;
    private $departmentId;
    private $description;

    /**
     * City constructor.
     * @param $adapter
     */
    public function __construct($adapter)
    {
        $table = "ciudad";
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
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    /**
     * @param mixed $departmentId
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;
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
            "  `id_departamento`," .
            "  `descripcion` " .
            " FROM" .
            "  `appprueba`." . $this->getTable() . " " .
            " WHERE `id_departamento` = '" . trim($this->getDepartmentId()) . "' " .
            "  AND `descripcion` = '" . trim($this->getDescription()) . "' ;";

        $data = $this->executeSql($query);
        return $data;
    }

    /**
     *
     */
    public function getAllCities()
    {
        $query = " SELECT " .
            "   t2.`id`," .
            "   t1.`descripcion` AS departamento," .
            "   t2.`descripcion` AS ciudad " .
            " FROM" .
            "   `departamento` t1 " .
            "   INNER JOIN `ciudad` t2 " .
            "     ON t1.`id` = t2.`id_departamento` ";

        $data = $this->getDb()->query($query);

        //Devolvemos el resultset en forma de array de objetos
        while ($row = $data->fetch_object()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }


    /**
     * @return bool|mysqli_result
     */
    public function save()
    {

        $query = "INSERT INTO " . $this->getTable() . " (id_departamento,descripcion)
                VALUES(
                       '" . trim($this->getDepartmentId()) . "',
                       '" . trim($this->getDescription()) . "');";

        $save = $this->db()->query($query);

        return $save;
    }

    /**
     * @return bool|mysqli_result
     */
    public function update()
    {

        $query = " UPDATE `appPrueba`.`ciudad` " .
            " SET" .
            " `descripcion` = '" . $this->getDescription() . "'" .
            " WHERE" .
            "   `id` = " . $this->getId() . " ;";

        $save = $this->db()->query($query);

        return $save;
    }


}