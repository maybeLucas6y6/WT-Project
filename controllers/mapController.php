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
                $this->respondJSON($this->model->addAsset($description, $address, $price));
                break;

            case 'temperature':
                $lat = $this->params[0] ?? null;
                $lng = $this->params[1] ?? null;
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
