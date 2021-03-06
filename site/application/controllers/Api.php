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


                if($this->authModule($decoded)){
                    $this->changeTeamnameHandler($server, $decoded);
                } else {
                    $this->respError(400, "Bad request", "Bad auth");
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

                if($this->authModule($decoded)){
                    $this->changeFlagHandler($server, $decoded);
                } else {
                    $this->respError(400, "Bad request", "Bad auth");
                }

            } else {
                $this->respError(400, "Bad request", "Invalid request type");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or no argument");
        }

    }

    public function changeMap($server=null){


        if($server!=null && is_numeric($server)){

            if($_SERVER['REQUEST_METHOD'] == "POST") {

                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata, true);

                if($this->authModule($decoded)){
                    $this->changeMapHandler($server, $decoded);
                } else {
                    $this->respError(400, "Bad request", "Bad auth");
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

                if($this->authModule($decoded)){
                    $this->doneTaskHandler($server, $decoded);
                } else {
                    $this->respError(400, "Bad request", "Bad auth");
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

                if($this->authModule($decoded)){
                    $this->setPointsHandler($server, $decoded);
                } else {
                    $this->respError(400, "Bad request", "Bad auth");
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

                if($this->authModule($decoded)){
                    $this->changeStatsHandler($server, $decoded);
                } else {
                    $this->respError(400, "Bad request", "Bad auth");
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

                if($this->db->affected_rows() > 0){
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
                    $this->respError(400, "Bad request", "Wrong username or password");
                }
            } else {
                $this->respError(400, "Bad request", "Invalid or no argument");
            }

        } else {
            $this->respError(400, "Bad request", "Invalid request type");
        }
    }

    public function getServers(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){

            $query = $this->db->query("SELECT * FROM `servers`");

            $response = array();

            foreach ($query->result() as $row)
            {
                array_push($response, array(
                    "server_number" => $row->id,
                    "server_name" =>$row->servername
                ));
            }

            header('Content-Type: application/json');
            $json_response = json_encode($response);
            echo $json_response;
        }
    }

    public function createUser(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $rawdata = file_get_contents("php://input");
            $decoded = json_decode($rawdata, true);

            if($this->authModule($decoded)){
                $this->createUserHandler($decoded);
            } else {
                $this->respError(400, "Bad request", "Bad auth");
            }

        } else {
            $this->respError(400, "Bad request", "Invalid request type");
        }
    }

    public function addServer(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $rawdata = file_get_contents("php://input");
            $decoded = json_decode($rawdata, true);

            if($this->authModule($decoded)){
                $this->addServerHandler($decoded);
            } else {
                $this->respError(400, "Bad request", "Bad auth");
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

	// Checker function for token
    private function is_token($str){
        if ( base64_encode(base64_decode($str, true)) === $str){
            return true;
        } else {
            return false;
        }
    }

    // Handlers for the controller functions
    private function changeTeamnameHandler($server, $decoded){
        if (isset($decoded["name"], $decoded["team"]) && !empty($decoded["team"] . $decoded["name"])){
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
    }

    private function changeFlagHandler($server, $decoded){
        if (isset($decoded["country"], $decoded["team"]) && strlen($decoded["country"]) == 2 && !empty($decoded["team"] ) && !is_numeric($decoded["country"])){

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
    }

    private function changeMapHandler($server, $decoded){
        $maps = array(
            "de_cache",
            "de_dust2",
            "de_mirage",
            "de_overpass",
            "de_nuke",
            "de_inferno",
            "de_train",
            "de_cbble",
            "de_canals",
            "de_subzero",
            "de_shortdust",
            "de_shortnuke",
            "de_shorttrain",
            "cs_agency",
            "cs_assault",
            "cs_italy",
            "cs_office",
            "de_austria",
            "de_biome",
            "ar_baggage",
            "de_lake",
            "ar_monastery",
            "de_safehouse",
            "ar_shoots",
            "de_stmarc",
            "de_bank",
            "de_sugarcane",
            "ar_dizzy",
            "gd_rialto"
        );

        if (isset($decoded["map"]) && in_array($decoded["map"], $maps)){

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

    }

    private function doneTaskHandler($server, $decoded){
        if(isset($decoded["tasknum"]) && !empty($decoded["tasknum"]) && is_numeric($decoded["tasknum"])){
            $sql = "INSERT INTO `old_jobs` SELECT * FROM `jobs` WHERE `tasknum` = ?";
            $this->db->query($sql, array($decoded["tasknum"]));
            $sql = "DELETE FROM `jobs` WHERE `tasknum` = ?";
            $this->db->query($sql, array($decoded["tasknum"]));
            $this->respError(200, "OK", "Task marked as done");
        } else {
            $this->respError(400, "Bad request", "Invalid or no tasknum");
        }
    }

    private function setPointsHandler($server, $decoded){
        if(isset($decoded["ctpoint"], $decoded["tpoint"]) && !empty($decoded["ctpoint"] . $decoded["tpoint"]) && is_numeric($decoded["ctpoint"]) && is_numeric($decoded["tpoint"])){
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
    }

    private function changeStatsHandler($server, $decoded){
        if(isset($decoded["txt"], $decoded["team1"], $decoded["team2"], $decoded["key"]) && !empty($decoded["team1"] . $decoded["team2"])){
            $count = 0;
            if(!empty($decoded["txt"])){
                $sql = "INSERT INTO `jobs`(`servernum`, `task`) VALUES (?,?)";
                $this->db->query($sql, array($server, "mp_teammatchstat_txt " . $decoded["txt"]));
                if($this->db->affected_rows() > 0){
                    $count+=1;
                }
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
            if($count >= 2){
                $this->respError(200, "OK", "Task sent");
            } else {
                $this->respError(500, "Internal error", $count . "/3 task sent");
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or empty input");
        }
    }

    private function createUserHandler($decoded){
        if(isset($decoded["username"], $decoded["password"]) && !empty($decoded["username"] . $decoded["password"])){
            $sql = "SELECT * FROM `users` WHERE `username`=?";
            $this->db->query($sql, $decoded["username"]);
            if($this->db->affected_rows() > 0){
                $this->respError(400, "Bad request", "User already exists!");
            } else {
                if(preg_match("#[a-zA-Z][0-9]+#", $decoded["password"]) && strlen($decoded["password"]) >= 8){
                    $sql = "INSERT INTO `users`(`username`, `password`) VALUES (?,?)";
                    $this->db->query($sql, array($decoded["username"], password_hash($decoded["password"], PASSWORD_BCRYPT, ["cost" => 10])));
                    if($this->db->affected_rows() > 0){
                        $this->respError(200, "OK", "User created!");
                    } else {
                        $this->respError(500, "Server Error", "Something went wrong");
                    }
                } else {
                    $this->respError(400, "Bad request", "Password not fulfills the requirements");
                }
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or empty input");
        }
    }

    private function addServerHandler($decoded){
        if(isset($decoded["servername"], $decoded["serverid"]) && !empty($decoded["servername"] . $decoded["serverid"])){
            $sql = "SELECT * FROM `servers` WHERE `id`=?";
            $this->db->query($sql, $decoded["serverid"]);
            if($this->db->affected_rows() > 0){
                $this->respError(400, "Bad request", "Server ID already exists!");
            } else {
                $sql = "INSERT INTO `servers`(`id`, `servername`) VALUES (?,?)";
                $this->db->query($sql, array($decoded["serverid"], $decoded["servername"]));
                if($this->db->affected_rows() > 0){
                    $this->respError(200, "OK", "Server added!");
                } else {
                    $this->respError(500, "Server Error", "Something went wrong");
                }
            }
        } else {
            $this->respError(400, "Bad request", "Invalid or empty input");
        }
    }

    private function authModule($decoded){

        if (isset($decoded["key"]) && $decoded["key"] == API_KEY){
            return true;
        } else if(isset($decoded["key"]) && $this->is_token($decoded["key"])) {
            $token = explode(":",base64_decode($decoded["key"], true));
            $sql = "SELECT * FROM `users` WHERE `username`=?";
            $query = $this->db->query($sql, array($token[0]));
            foreach ($query->result() as $row)
            {
                if(password_verify($token[1], $row->password)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

}
