<?php namespace PwLabs\LaravelHealthCheck\Controllers;

use App;
use Controller;
use Response;

class HealthCheckController extends Controller {

    protected $healthChecks;

    public function __construct() {
        $this->healthChecks = App::make('health-checks');
    }

    public function index()
    {
        $checkNames = array_map( function($check) {
            return $check->getName();
        }, $this->healthChecks );

        $data['components'] = [];
        $checked = [];
        foreach ($checkNames as $checkName) {
            $check = $this->getHealthCheckByName($checkName);
            $checked['type'] = $checkName;
            $checked['status'] = $check->check();
            array_push($data['components'], $checked);
        }

        return Response::json([
            'statusCode' => 200,
            'data' => $data,
        ]);
    }

    public function show($checkName)
    {
        $check = $this->getHealthCheckByName($checkName);
        $result = $check->check();
        return Response::json([
            'status' => $result,
        ]);
    }

    protected function getHealthCheckByName($name) {
        foreach( $this->healthChecks as $check ) {
            if( $name == $check->getName() ) {
                return $check;
            }
        }
        return null;
    }
}