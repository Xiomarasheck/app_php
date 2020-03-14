<?php

class PersonsController extends Controller
{
    public $connection;
    public $adapter;

    public function __construct()
    {
        parent::__construct();

        $this->connection = new Connection();
        $this->adapter = $this->connection->connection();

    }

    /**
     * @return array
     */
    private function getAllPersons()
    {
        $cities = new Person($this->adapter);
        return $cities->getAllPersons();
    }


    /**
     *
     */
    public function index()
    {
        $allPersons = $this->getAllPersons();

        //Cargamos la vista index y le pasamos valores
        $this->view("persons/index.php", array(
            "allPersons" => $allPersons
        ));
    }


    /**
     *
     */
    public function viewCreate()
    {

        $types = new TypeDocument($this->adapter);
        $allTypes = $types->getAllTypes();


        //Creamos el objeto cities
        $city = new City($this->adapter);
        $allCities = $city->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("persons/create.php", array(
            "allCities" => $allCities,
            "allTypes" => $allTypes,
        ));

    }


    /**
     *
     */
    public function viewEdit()
    {
        if (isset($_GET["id"])) {


            $types = new TypeDocument($this->adapter);
            $allType = $types->getAllTypes();
            var_dump($allType);

            //Creamos el objeto cities
            $cities = new City($this->adapter);
            $city = $cities->getById($_GET["id"]);


            if (!empty($city)) {
                //Creamos el objeto cities
                $department = new Department($this->adapter);
                $department = $department->getById($city->id_departamento);


                //Cargamos la vista index y le pasamos vasslores
                $this->view("persons/edit.php", array(
                    "department" => $department,
                    'city' => $city
                ));

                exit();
            }

        }
        $errors = ['no se encontraron datos para editar'];

        //Cargamos la vista index y le pasamos vasslores
        $this->view("persons/edit.php", array(
            "errors" => $errors
        ));

    }

    /**
     *
     */
    public function create()
    {
        $error = [];
        $message = "";

        if (isset($_POST["name"])) {


            $objCity = new City($this->adapter);
            $city = $objCity->getById($_POST['id_city']);

            if (!empty($city)) {

                $objType = new TypeDocument($this->adapter);
                $type = $objType->getById($_POST['type_document']);
                if (!empty($type)){

                    $objPerson = new Person($this->adapter);
                    $objPerson->setName($_POST['name']);
                    $objPerson->setLastName($_POST['last_name']);
                    $objPerson->setCityId($_POST['id_city']);
                    $objPerson->setTypeDocument($_POST['type_document']);
                    $objPerson->setNumDocument($_POST['num_document']);

                    $objPerson->save();
                    $message = "Persona Registrada con éxito";
                }else{
                    $error[] = "No se encontro tipo de documento";
                }
            }else{
                $error[] = "No se encontro ciudad";
            }
        }


        $types = new TypeDocument($this->adapter);
        $allTypes = $types->getAllTypes();


        //Creamos el objeto cities
        $city = new City($this->adapter);
        $allCities = $city->getAll();

//        //Cargamos la vista index y le pasamos valores
//        $this->view("persons/create.php", array(
//            "errors" => $error,
//            "message" => $message,
//            "allCities" => $allCities,
//            "allTypes" => $allTypes,
//        ));

    }

    /**
     *
     */
    public function edit()
    {
        $error = [];
        $message = "";

        if (isset($_POST["id"])) {

            $objCity = new City($this->adapter);
            $objCity->setId($_POST["id"]);
            $objCity->setDescription($_POST["descripcion"]);

            $data = $objCity->getCity();

            if ($data === true) {
                $objCity->update();
                $message = "Ciudad Actualizada con éxito";
            } else {
                $error[] = "La ciudad ya se encuentra creada";
            }
        }


        //Cargamos la vista index y le pasamos valores
        $this->view("persons/index.php", array(
            "allCities" => $this->getAllPersons(),
            "errors" => $error,
            "message" => $message
        ));

    }


    /**
     *
     */
    public function destroy()
    {
        $error = [];
        $message = [];
        if (isset($_GET["id"])) {

            $id = (int)$_GET["id"];
            $objCity = new Person($this->adapter);
            $objCity->deleteById($id);
            $message = "Persona Eliminada con éxito";

        } else {
            $error[] = "No se encontraron datos para eliminar";
        }

        //Cargamos la vista index y le pasamos valores
        $this->view("persons/index.php", array(
            "allCities" => $this->getAllPersons(),
            "errors" => $error,
            "message" => $message
        ));
    }


    /**
     * @param string $controller
     * @param string $action
     */
    public function redirect($controller = 'Cities', $action = 'index')
    {
        header("Location:processActions.php?controller=" . $controller . "&method=" . $action);
    }


}