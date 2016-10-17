<?php namespace PwLabs\LaravelHealthCheck\Controllers;

use App;
use Controller;
use Request;
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

        $statusCode = 200;
        $data['components'] = [];
        $checked = [];

        foreach ($checkNames as $checkName) {
            $status = $this->show($checkName, 1);
            $checked['type'] = $checkName;
            $checked['status'] = $status;

            if($status != 200) {
                $statusCode = 500;
            }
            array_push($data['components'], $checked);
        }

        return Response::json([
            'statusCode' => $statusCode,
            'data' => $data,
        ]);
    }

    public function show($checkName, $mode=0)
    {
        $check = $this->getHealthCheckByName($checkName);
        if($check->check() == true) {
            $code = 200;
        } else {
            $code = 500;
        }
        if($mode==1) {
            return $code;
        } else {
            return Response::json([
                'statusCode' => $code,
            ]);
        }
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
