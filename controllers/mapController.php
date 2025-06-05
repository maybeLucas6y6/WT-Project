<?php

class MapController extends Controller {
    private $authMiddleware;
    public function __construct($action, $params) {
        $this->authMiddleware = new AuthMiddleware();

        // Require authentication for all actions in this controller
        if (!$this->authMiddleware->requireAuth()) {
            return;
        }
        $model = new MapModel();
        $view = new MapView();
        parent::__construct($action, $params, $model, $view);
    }

    public function handleRequest()
    {
        // echo "Handling request for action: {$this->action}<br />";
        switch ($this->action) {
            case 'pollution':
                $lat = $this->params[0] ?? 40;
                $lng = $this->params[1] ?? 40;
                $radius = $this->params[2] ?? 10000;
                $limit = $this->params[3] ?? 50;
                $this->respondJSON($this->model->getPollutionData($lat, $lng, $radius, $limit));
                break;

            case 'sensor': // sensor tot OpenAq, tot la model
                $id = $this->params[0] ?? null;
                $this->respondJSON($this->model->getSensorData($id));
                break;

            case 'asset':
                $this->respondJSON($this->model->getAssets());
                break;

            case 'addAsset':
                $description = $this->params[0] ?? null;
                $address = $this->params[1] ?? null;
                $price = $this->params[2] ?? null;
                $lat = $this->params[3] ?? null;
                $lng = $this->params[4] ?? null;
                $category = $this->params[5] ?? null;
                $user = $this->authMiddleware->getAuthenticatedUser();
                $this->respondJSON($this->model->addAsset($description, $address, $price, $lat, $lng, $user['id'],$category));
                break;

            case 'temperature':
                $lat = $this->params[0] ?? null;
                $lng = $this->params[1] ?? null;
                $this->respondJSON($this->model->getTemperatureData($lat, $lng));
                break;

            case 'filterAssets':
                $min_value = $this->params[0] ?? null;
                $max_value = $this->params[1] ?? null;
                $this->respondJSON($this->model->filterAssets($min_value, $max_value));
                break;  
            
            case 'fetchFavoriteAssets':
                $user = $this->authMiddleware->getAuthenticatedUser();
                $this->respondJSON($this->model->fetchFavoriteAssets($user['id']));
                break;

            case 'fetchNearbyAssets':
                $lat = $this->params[0] ?? null;
                $lng = $this->params[1] ?? null;
                $this->respondJSON($this->model->fetchNearbyAssets($lat, $lng));
                break;

            default:
                // Default action, render the map view
                $this->view->render([]);
                break;
        }
    }

    private function respondJSON($data)
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        echo json_encode($data);
    }

    public function render() {
        $this->handleRequest();
    }
}
