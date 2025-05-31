<?php

class MapController extends Controller
{
    protected $model;
    protected $view;
    public function __construct()
    {
        $this->model = new MapModel();
    }

    public function handleRequest()
    {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'pollution':
                $lat = $_GET['lat'] ?? null;
                $lng = $_GET['lng'] ?? null;
                $radius = $_GET['radius'] ?? 10000;
                $limit = $_GET['limit'] ?? 50;
                $this->respondJSON($this->model->getPollutionData($lat, $lng, $radius, $limit));
                break;

            case 'sensor':
                $id = $_GET['id'] ?? null;
                $this->respondJSON($this->model->getSensorData($id));
                break;

            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action']);
        }
    }

    private function respondJSON($data)
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        echo json_encode($data);
    }
}
