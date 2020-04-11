<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{

	public function index()
	{
		$this->respError(403, "Forbidden", "Nothing here");
	}

	public function demo($server=null){

	    if($server!=null && is_numeric($server)){
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);
            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }

    }

    public function changeTeamname($server=null){

    }

    public function changeFlag($server=null){

    }

    public function changeMap($server=null){

    }
	
	// Not reachable from browser or through API request
	private function respError($httpcode, $httpstatus, $errormessage)
	{
		$response['http_code'] = $httpcode;
		$response['http_status'] = $httpstatus;
		$response['error_message'] = $errormessage;
		header('Content-Type: application/json');
		$json_response = json_encode($response);
		echo $json_response;
	}
}
