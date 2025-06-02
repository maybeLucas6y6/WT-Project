<?php

class assetController extends Controller{
    public function __construct($action, $params) {
        $model = new assetModel();
        $view = new assetView();
        parent::__construct($action, $params, $model, $view);
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