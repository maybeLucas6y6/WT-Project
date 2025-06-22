<?php
class DocumentationController extends Controller {

    public function __construct($action, $params)
    {
        $model = null;
        $view = new DocumentationView();
        parent::__construct($action, $params, $model, $view);
    }
    public function render()
    {
        $this->view->render('TODO');
    }
}