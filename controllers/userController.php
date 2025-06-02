<?php

class UserController extends Controller {
    public function __construct($action, $params) {
        $model = new UserModel();
        $view = new UserView();
        parent::__construct($action, $params, $model, $view);
    }
}