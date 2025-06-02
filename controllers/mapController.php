<?php

class MapController extends Controller {
    public function __construct($action, $params) {
        $model = new MapModel();
        $view = new MapView();
        parent::__construct($action, $params, $model, $view);
    }

    public function handleRequest()
    {
        // echo "Handling request for action: {$this->action}<br />";
        switch ($this->action) {
            case 'pollution':
                $lat = $_GET['lat'] ?? 40;
                $lng = $_GET['lng'] ?? 40;
                $radius = $_GET['radius'] ?? 10000;
                $limit = $_GET['limit'] ?? 50;
                $this->respondJSON($this->model->getPollutionData($lat, $lng, $radius, $limit));
                break;

            case 'sensor': // sensor tot OpenAq, tot la model
                $id = $_GET['id'] ?? null;
                $this->respondJSON($this->model->getSensorData($id));
                break;

            case 'asset':
                $this->respondJSON($this->model->getAssets());
                break;

            case 'addAsset':
                $description = $_POST['description'] ?? null;
                $address = $_POST['address'] ?? null;
                $price = $_POST['price'] ?? null;
                $this->respondJSON($this->model->addAsset($description, $address, $price));
                break;

            case 'temperature':
                $lat = $_GET['lat'] ?? null;
                $lng = $_GET['lng'] ?? null;
                $this->respondJSON($this->model->getTemperatureData($lat, $lng));
                break;
                
            default:
                // Default action, render the map view
                $this->view->render();
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
