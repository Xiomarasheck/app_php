<?php


class LoginController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function validateLogin()
    {

        $objPerson = new Person();
        $objPerson->setName($_POST['namePerson']);
        $data = $objPerson->getPersonName();

        if (!empty($data)){
            session_start();
            $_SESSION['personId']  = $data->id;
            $_SESSION['personName']  = $data->name;
        }


        //Cargamos la vista index y le pasamos valores
        $this->view("home.php", array(
        ));
    }
}