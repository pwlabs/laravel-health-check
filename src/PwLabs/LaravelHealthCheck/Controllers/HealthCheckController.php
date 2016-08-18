<?php namespace PwLabs\LaravelHealthCheck\Controllers;

use App;
use Controller;
use Request;
use Response;
use GuzzleHttp\Client;

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

        $statusCode = 200;
        $data['components'] = [];
        $checked = [];
        $client = new Client;

        foreach ($checkNames as $checkName) {
            $response = $client->get(Request::url().'/'.$checkName);
            $result = $response->json();
            $checked['type'] = $checkName;
            $checked['status'] = $result['statusCode'];

            if($checked['status'] != 200) {
                $statusCode = 500;
            }
            array_push($data['components'], $checked);
        }

        return Response::json([
            'statusCode' => $statusCode,
            'data' => $data,
        ]);
    }

    public function show($checkName)
    {
        $check = $this->getHealthCheckByName($checkName);
        if($check->check() == true) {
            $code = 200;
        } else {
            $code = 500;
        }
        return Response::json([
            'statusCode' => $code,
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
