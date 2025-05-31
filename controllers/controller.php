<?php
abstract class Controller
{
    protected $model;
    protected $view;

    public function __construct()
    {   //deci caut in numele clasei "Controller" si apoi il inlocuiesc cu Model (e.g. UserController -> UserModel)
        $numeModel = str_replace("Controller", "Model", get_class($this));
        $this->model = new $numeModel;
        //idem
        $numeView = str_replace("Controller","View", get_class($this));
        $this->view = new $numeView;
    }
}