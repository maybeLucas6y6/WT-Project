<?php

class HomeController extends Controller
{
    private $authMiddleware;

    public function __construct($action, $params)
    {
        $this->authMiddleware = new AuthMiddleware();

        // Require authentication for all actions in this controller
        if (!$this->authMiddleware->requireAuth()) {
            return;
        }

        $model = null;
        $view = new HomeView();
        parent::__construct($action, $params, $model, $view);
    }

    public function render()
    {
        $user = $this->authMiddleware->getAuthenticatedUser();

        $this->view->render('TODO');
    }
}
