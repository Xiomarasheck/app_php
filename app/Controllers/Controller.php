<?php


class Controller
{

    public function __construct()
    {
        require_once path_URL . '/app/Controllers/Class/Connection.php';


        //Include models
        foreach (glob(path_URL . "/app/Model/*.php") as $file) {
            require_once $file;
        }
    }

    //Plugins y funcionalidades

    /*
    * Este método lo que hace es recibir los datos del controller en forma de array
    * los recorre y crea una variable dinámica con el indice asociativo y le da el
    * valor que contiene dicha posición del array, luego carga los helpers para las
    * vistas y carga la vista que le llega como parámetro. En resumen un método para
    * renderizar vistas.
    */
    public function view($vista, $dates)
    {
        foreach ($dates as $id_assoc => $valor) {
            ${$id_assoc} = $valor;
        }



        require_once path_URL . '/views/' . $vista;
    }
}