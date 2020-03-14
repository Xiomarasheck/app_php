<?php

class CitiesController extends Controller
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
    private function getAllCities()
    {
        $cities = new City($this->adapter);
        return $cities->getAllCities();
    }


    /**
     *
     */
    public function index()
    {
        $allCities = $this->getAllCities();

        //Cargamos la vista index y le pasamos valores
        $this->view("cities/index.php", array(
            "allCities" => $allCities
        ));
    }


    /**
     *
     */
    public function viewCreate()
    {
        //Creamos el objeto cities
        $department = new Department($this->adapter);
        $allDepartments = $department->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("cities/create.php", array(
            "allDepartments" => $allDepartments
        ));

    }


    /**
     *
     */
    public function viewEdit()
    {
        if (isset($_GET["id"])) {

            //Creamos el objeto cities
            $cities = new City($this->adapter);
            $city = $cities->getById($_GET["id"]);


            if (!empty($city)) {
                //Creamos el objeto cities
                $department = new Department($this->adapter);
                $department = $department->getById($city->id_departamento);


                //Cargamos la vista index y le pasamos vasslores
                $this->view("cities/edit.php", array(
                    "department" => $department,
                    'city' => $city
                ));

                exit();
            }

        }
        $errors = ['no se encontraron datos para editar'];

        //Cargamos la vista index y le pasamos vasslores
        $this->view("cities/edit.php", array(
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

        if (isset($_POST["id_departamento"])) {

            $objCity = new City($this->adapter);
            $objCity->setDepartmentId($_POST["id_departamento"]);
            $objCity->setDescription($_POST["descripcion"]);

            $data = $objCity->getCity();


            if ($data === true) {
                $objCity->save();
                $message = "Ciudad Registrada con éxito";
            } else {
                $error[] = "La ciudad ya se encuentra creada";
            }
        }

        //Creamos el objeto cities
        $department = new Department($this->adapter);
        $allDepartments = $department->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("cities/create.php", array(
            "allDepartments" => $allDepartments,
            "errors" => $error,
            "message" => $message

        ));

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
        $this->view("cities/index.php", array(
            "allCities" => $this->getAllCities(),
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
            $objCity = new City($this->adapter);
            $objCity->deleteById($id);
            $message = "Ciudad Eliminada con éxito";

        } else {
            $error[] = "No se encontraron datos para eliminar";
        }

        //Cargamos la vista index y le pasamos valores
        $this->view("cities/index.php", array(
            "allCities" => $this->getAllCities(),
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