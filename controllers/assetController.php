<?php

class assetController extends Controller{
    public $model;
    public $view;

    public function __construct(){
        parent::__construct();
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