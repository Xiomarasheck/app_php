<?php

class Person extends Model
{
    private $id;
    private $cityId;
    private $typeDocument;
    private $numDocument;
    private $name;
    private $lastName;


    /**
     * Person constructor.
     * @param $adapter
     */
    public function __construct($adapter)
    {
        $table = "persona";
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
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * @param mixed $cityId
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    /**
     * @return mixed
     */
    public function getTypeDocument()
    {
        return $this->typeDocument;
    }

    /**
     * @param mixed $typeDocument
     */
    public function setTypeDocument($typeDocument)
    {
        $this->typeDocument = $typeDocument;
    }

    /**
     * @return mixed
     */
    public function getNumDocument()
    {
        return $this->numDocument;
    }

    /**
     * @param mixed $numDocument
     */
    public function setNumDocument($numDocument)
    {
        $this->numDocument = $numDocument;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    /**
     *
     */
    public function getPersonName()
    {
        $query = "SELECT " .
            "  `id`," .
            "  `name`" .
            " FROM" .
            "  `appprueba`." . $this->getTable() . " " .
            " WHERE `nombre` = '" . trim($this->getName()) . "' ;";

        $data = $this->executeSql($query);
        return $data;
    }


    /**
     * @return bool|mysqli_result
     */
    public function save()
    {

        $query = " INSERT INTO appPrueba.`persona` " .
            " 	(" .
            " 	`idCiudad`, " .
            " 	`idTipoDocumento`, " .
            " 	`numeroDocumento`, " .
            " 	`nombre`, " .
            " 	`apellido`" .
            " 	)" .
            " VALUES" .
            " 	(" .
            " 	'" . $this->getCityId() . "', " .
            " 	'" . $this->getTypeDocument() . "', " .
            " 	'" . $this->getNumDocument() . "', " .
            " 	'" . trim($this->getName()) . "', " .
            " 	'" . trim($this->getLastName()) . "'" .
            " 	);";

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

    /**
     *
     */
    public function getAllPersons()
    {
        $query = " SELECT " .
            "   * " .
            " FROM" .
            "   `personas` t1 ";

        $data = $this->getDb()->query($query);

        //Devolvemos el resultset en forma de array de objetos
        while ($row = $data->fetch_object()) {
            $resultSet[] = $row;
        }

        return $resultSet;
    }


}