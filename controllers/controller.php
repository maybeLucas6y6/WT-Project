<?php

abstract class Controller {
    protected $model;
    protected $view;
    protected $action;
    protected $params;

    public function __construct($action, $params, $model, $view) {
        $this->action = $action;
        $this->params = $params;
        $this->model = $model;
        $this->view = $view;
    }

    public abstract function render();
}
