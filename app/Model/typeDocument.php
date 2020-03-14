<?php

class TypeDocument extends Model
{
    private $id;
    private $description;

    /**
     * City constructor.
     * @param $adapter
     */
    public function __construct($adapter)
    {
        $table = "tipoDocumento";
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
    public function getAllTypes()
    {
        $query = " SELECT " .
            "   `id`," .
            "   `descripcion` " .
            " FROM " .
            "   `" . $this->getTable() . "  ";

        $data = $this->getDb()->query($query);

        //Devolvemos el resultset en forma de array de objetos
        while ($row = $data->fetch_object()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }


}