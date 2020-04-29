<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{

	public function index()
	{
		$this->respError(403, "Forbidden", "Nothing here");
	}

    public function changeTeamname($server=null){
        if($server!=null && is_numeric($server)){

            if($_SERVER['REQUEST_METHOD'] == "POST") {

                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);

                if (isset($decoded["name"], $decoded["team"], $decoded["apikey"]) && !empty($decoded["team"] . $decoded["name"] . $decoded["apikey"]) && $decoded["apikey"] == API_KEY){
                    if($decoded["team"] == 1){
                        $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                        $this->db->query($sql, array($server, "mp_teamname_1 " . $decoded["name"]));

                        if($this->db->affected_rows() > 0){
                            $this->respError(200, "OK", "Task sent");
                        } else {
                            $this->respError(500, "Internal error", "Task not sent");
                        }
                    } else if($decoded["team"] == 2){
                        $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                        $this->db->query($sql, array($server, "mp_teamname_2 " . $decoded["name"]));

                        if($this->db->affected_rows() > 0){
                            $this->respError(200, "OK", "Task sent");
                        } else {
                            $this->respError(500, "Internal error", "Task not sent");
                        }
                    } else{
                        $this->respError(400, "Bad request", "No or invalid team");
                    }
                } else {
                    $this->respError(400, "Bad request", "No or invalid name or team");
                }
            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }
    }

    public function changeFlag($server=null){

        if($server!=null && is_numeric($server)){

            if($_SERVER['REQUEST_METHOD'] == "POST") {

                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);

                if (isset($decoded["country"], $decoded["team"], $decoded["apikey"]) && strlen($decoded["country"]) == 2 && !empty($decoded["team"] . $decoded["apikey"]) && !is_numeric($decoded["country"]) && $decoded["apikey"] == API_KEY){

                    if($decoded["team"] == 1){
                        $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                        $this->db->query($sql, array($server, "mp_teamflag_1 " . $decoded["country"]));

                        if($this->db->affected_rows() > 0){
                            $this->respError(200, "OK", "Task sent");
                        } else {
                            $this->respError(500, "Internal error", "Task not sent");
                        }
                    } else if($decoded["team"] == 2){
                        $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                        $this->db->query($sql, array($server, "mp_teamflag_2 " . $decoded["country"]));

                        if($this->db->affected_rows() > 0){
                            $this->respError(200, "OK", "Task sent");
                        } else {
                            $this->respError(500, "Internal error", "Task not sent");
                        }
                    } else{
                        $this->respError(400, "Bad request", "No or invalid team");
                    }

                } else {
                    $this->respError(400, "Bad request", "No or invalid country");
                }
            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }

    }

    public function changeMap($server=null){

	    $maps = array(
	        "de_dust2",
            "de_inferno",
            "de_train",
            "de_mirage",
            "de_nuke",
            "de_overpass",
            "de_vertigo"
        );

        if($server!=null && is_numeric($server)){

            if($_SERVER['REQUEST_METHOD'] == "POST") {

                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);

                if (isset($decoded["map"], $decoded["apikey"]) && $decoded["apikey"] == API_KEY && in_array($decoded["map"], $maps)){

                    $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                    $this->db->query($sql, array($server, "changelevel " . $decoded["map"]));

                    if($this->db->affected_rows() > 0){
                        $this->respError(200, "OK", "Task sent");
                    } else {
                        $this->respError(500, "Internal error", "Task not sent");
                    }

                } else {
                    $this->respError(400, "Bad request", "No or invalid map");
                }
            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }

    }

    public function doneTask($server=null){

        if($server!=null && is_numeric($server)){
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);

                if(isset($decoded["tasknum"], $decoded["apikey"]) && !empty($decoded["tasknum"] . $decoded["apikey"]) && is_numeric($decoded["tasknum"]) && $decoded["apikey"] == API_KEY){
                    $sql = "INSERT INTO `old_jobs` SELECT * FROM `jobs` WHERE `tasknum` = ?";
                    $this->db->query($sql, array($decoded["tasknum"]));
                    $sql = "DELETE FROM `jobs` WHERE `tasknum` = ?";
                    $this->db->query($sql, array($decoded["tasknum"]));
                    $this->respError(200, "OK", "Task marked as done");
                } else {
                    $this->respError(400, "Bad request", "Invalid or no tasknum");
                }
            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }

    }

    public function getTasks($server=null){

        if($server!=null && is_numeric($server)){
            if($_SERVER['REQUEST_METHOD'] == "GET") {
                $sql = "SELECT * FROM `jobs` WHERE `servernum`= ?";
                $query = $this->db->query($sql, array($server));

                $response = array();
                foreach ($query->result() as $row)
                {
                    array_push($response, array(
                        "tasknum" =>$row->tasknum,
                        "task" => $row->task
                    ));
                }
                header('Content-Type: application/json');
                $json_response = json_encode($response);
                echo $json_response;
            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }

    }

    public function setPoints($server=null){

        if($server!=null && is_numeric($server)){
            if($_SERVER['REQUEST_METHOD'] == "POST") {

                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);

                if(isset($decoded["ctpoint"], $decoded["tpoint"], $decoded["apikey"]) && $decoded["apikey"] == API_KEY && !empty($decoded["ctpoint"] . $decoded["tpoint"]) && is_numeric($decoded["ctpoint"]) && is_numeric($decoded["tpoint"])){
                    $sql = "SELECT * FROM `server_points` WHERE `servernum`= ?";
                    $this->db->query($sql, array($server));

                    if ($this->db->affected_rows() > 0){
                        $sql = "UPDATE `server_points` SET `t_point`=?,`ct_point`=? WHERE `servernum`=?";
                        $this->db->query($sql, array($decoded["tpoint"], $decoded["ctpoint"], $server));
                        if ($this->db->affected_rows() > 0){
                            $this->respError(200, "OK", "Points updated");
                        } else {
                            $this->respError(500, "Internal error", "Points not updated");
                        }
                    } else {
                        $sql = "INSERT INTO `server_points`(`servernum`, `t_point`, `ct_point`) VALUES (?,?,?)";
                        $this->db->query($sql, array($server, $decoded["tpoint"], $decoded["ctpoint"]));
                        if ($this->db->affected_rows() > 0){
                            $this->respError(200, "OK", "Points updated and server registered");
                        } else {
                            $this->respError(500, "Internal error", "Points not updated and/or not registered");
                        }
                    }

                } else {
                    $this->respError(400, "Bad request", "Missing or invalid point");
                }


            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }

    }

    public function getPoints(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){

            $query = $this->db->query("SELECT * FROM `server_points`");

            $response = array();

            foreach ($query->result() as $row)
            {
                array_push($response, array(
                    "server" => $row->servernum,
                    "tpoint" =>$row->t_point,
                    "ctpoint" => $row->ct_point
                ));
            }

            header('Content-Type: application/json');
            $json_response = json_encode($response);
            echo $json_response;
        }
    }

    public function changeStats($server=null){
        if($server!=null && is_numeric($server)) {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);

                if(isset($decoded["txt"], $decoded["team1"], $decoded["team2"], $decoded["apikey"]) && $decoded["apikey"] == API_KEY && !empty($decoded["txt"] . $decoded["team1"] . $decoded["team2"])){
                    $count = 0;
                    $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                    $this->db->query($sql, array($server, "mp_teammatchstat_txt " . $decoded["txt"]));
                    if($this->db->affected_rows() > 0){
                        $count+=1;
                    }
                    $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                    $this->db->query($sql, array($server, "mp_teammatchstat_1 " . $decoded["team1"]));
                    if($this->db->affected_rows() > 0){
                        $count+=1;
                    }
                    $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                    $this->db->query($sql, array($server, "mp_teammatchstat_2 " . $decoded["team2"]));
                    if($this->db->affected_rows() > 0){
                        $count+=1;
                    }
                    if($count == 3){
                        $this->respError(200, "OK", "3/3 task sent");
                    } else {
                        $this->respError(500, "Internal error", $count . "/3 task sent");
                    }
                } else {
                    $this->respError(400, "Bad request", "Invalid or empty input");
                }
            }else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }
    }

    public function getToken(){
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $rawdata = file_get_contents("php://input");
            $decoded = json_decode($rawdata, true);

            if(isset($decoded["username"], $decoded["password"]) && !empty($decoded["username"] . $decoded["password"])){
                $sql = "SELECT * FROM `users` WHERE `username`=?";
                $query = $this->db->query($sql, array($decoded["username"]));

                foreach ($query->result() as $row)
                {
                    if(password_verify($decoded["password"], $row->password)) {
                        header('Content-Type: application/json');
                        $response = array(
                            "token" => base64_encode($decoded["username"] . ":". $decoded["password"])
                        );
                        $json_response = json_encode($response);
                        echo $json_response;
                    } else {
                        $this->respError(400, "Bad request", "Wrong username or password");
                    }
                }

            } else {
                $this->respError(400, "Bad request", "Invalid or no argument");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid request type");
        }
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
