<?php

class MapController extends Controller
{
    protected $model;
    protected $view;
    public function __construct()
    {
        $this->model = new MapModel();
        $this->view = new MapView('AIzaSyDQz3eIc4qVe1iNkZaehSEz94GhJRxkPP0');
    }

    public function handleRequest()
    {//eu primesc de la index o actiune, in functie de ce se intampla in scriptul de js
        $action = $_GET['action'] ?? null;

        switch ($action) { // daca trebuie datele de polutie, fac o cerere de la model, care face un api call la OpenAq
            case 'pollution':
                $lat = $_GET['lat'] ?? null;
                $lng = $_GET['lng'] ?? null;
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
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action']);
        }
    }

    private function respondJSON($data)
    {//trimite raspunsul inapoi la js
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        echo json_encode($data);
    }
}
