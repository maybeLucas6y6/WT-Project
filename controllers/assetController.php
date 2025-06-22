<?php

class assetController extends Controller
{
    private $authMiddleware;
    public function __construct($action, $params)
    {
        $this->authMiddleware = new AuthMiddleware();

        // Require authentication for all actions in this controller
        if (!$this->authMiddleware->requireAuth()) {
            return;
        }

        $model = new assetModel();
        $view = new assetView();
        parent::__construct($action, $params, $model, $view);
    }

    private function handleRequest()
    {
        switch ($this->action) {
            case "viewAsset":
                $this->viewAsset($this->params[0]);
                break;

            case "deleteAsset":
                $this->deleteAsset($_POST['id'] ?? null);
                break;

            case "addFavorite":
                $id = $this->params[0];
                $user = $this->authMiddleware->getAuthenticatedUser();
                $this->respondJSON($this->model->addFavorite($id, $user['id']));
                break;

            case "removeFavorite":
                $id = $this->params[0];
                $user = $this->authMiddleware->getAuthenticatedUser();
                $this->respondJSON($this->model->removeFavorite($id, $user["id"]));
                break;
        }
    }

    public function render()
    {
        $this->handleRequest();
    }

    public function viewAsset($id)
    {
        $asset = $this->model->getAssetById($id);

        if (!$asset) {
            echo "Asset not found.";
            return;
        }
        $this->view->initAsset($asset);
        $this->view->setTemplate("asset");
        $this->view->render(['is_admin' => $this->authMiddleware->isCurrentUserAdmin()]);
    }

    private function respondJSON($data)
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        echo json_encode($data);
    }

    private function deleteAsset($id)
    {
        $result = $this->model->deleteAsset($id);
        jumpTo('/map');

        if ($result) {
            $this->respondJSON(['success' => 'Asset deleted successfully']);
        } else {
            $this->respondJSON(['error' => 'Failed to delete asset']);
        }
    }
}
