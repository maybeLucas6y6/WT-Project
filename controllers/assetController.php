<?php

class assetController extends Controller{
    public function __construct($action, $params) {
        $model = new assetModel();
        $view = new assetView();
        parent::__construct($action, $params, $model, $view);
    }

    private function handleRequest(){
        switch ($this->action) {
            case "viewAsset":
                $this->viewAsset($this->params[0]);
                break;
        }
    }

    public function render() {
        $this->handleRequest();
    }

    public function viewAsset($id) {
        $asset = $this->model->getAssetById($id);

        if (!$asset) {
            echo "Asset not found.";
            return;
        }
        $this->view->initAsset($asset);
        $this->view->render();
    }
}