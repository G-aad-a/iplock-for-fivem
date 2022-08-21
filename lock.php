<?php


require_once('./functions.php');
require("./models/secure.php");
new secure(false);




class Lock {

    function __construct($id, $headers, $authkey, $data)
    {
        $this->Util = new Utility();
        $this->db = $this->Util->database;
        $this->config = include('config.php');
        $this->ip = $this->Util->getIP();
        $this->id = $id;
        $this->data = $data;
        $this->headers = $headers;
        $this->authKey = $authkey;


    }



    function isAllowed() {

        $res = $this->db->query("SELECT * FROM `whitelisted` WHERE `key` = ? AND `ip` = ? AND `script_id` = ?", $this->authKey, $this->ip, $this->id)->numRows();
        $result = $this->db->query("SELECT * FROM `whitelisted` WHERE `key` = ? AND `ip` = ? AND `script_id` = ?", $this->authKey, $this->ip, $this->id)->fetchArray();
        if($res > 0) {
            $expires = strtotime($result["expires"]);
            $today = strtotime(date("Y-m-d"));
            if ($today >= $expires) {
                return false;
            } else {

                if($result["disabled"] == 1 && $result == true) {
                    echo json_encode(array("message" => "we do not allow monkeys", "code" => 224393));
                    $this->Util->webhook($this->Util->getIP() . " Tried accessing but was disabled", true, $this->data, 4);
                    exit;
                }
                return true;
            }
        } else {
            $this->Util->webhook($this->Util->getIP() . " Tried accessing but wasnt allowed", true, $this->data);
            echo json_encode(array("message" => "we do not allow strangers", "code" => 24393));
            exit;
        }
    }
}


$util = new Utility();

$data;

if(!empty($_SERVER['HTTP_RESP']) && isset($_SERVER['HTTP_RESP'])) {
    $data = $_SERVER['HTTP_RESP'];
} else {
    $data = "NOT PROVIDED :/";
}

if(!empty($_GET["id"]) && isset($_GET["id"])) {
    $id = htmlspecialchars($_GET["id"]);
} else {
    $util->webhook($util->getIP() . " Tried accessing the script without any ID set - 'may be trying to crack'", true, $data);
    echo json_encode(array("message" => "no id", "code" => 857));
    exit;
}

/*
if (!isset($_SERVER['HTTP_USER_AGENT']) && empty($_SERVER['HTTP_USER_AGENT'])) {
    $util->webhook($util->getIP() . " Tried accessing the script  - 'may be trying to crack'", true);
    exit;
} else {
    if ($_SERVER['HTTP_USER_AGENT'] != "FXServer/PerformHttpRequest") {
        exit;
    }
}*/

if(!empty($_GET["key"]) && isset($_GET["key"])) {
    $key = htmlspecialchars($_GET["key"]);
} else {
    $util->webhook($util->getIP() . " Tried accessing the script without any Key set", true, $data, 2);
    echo json_encode(array("message" => "no key", "code" => 857));
    exit;
}




$lock = new Lock($id, apache_request_headers(), $key, $data);
if($lock->isAllowed()) {
    header("balls: true");
    $util->webhook($util->getIP() . " Accessed the script with the key: " . $key, false, $data, 3);
    echo json_encode(array("code" => 299, "text" => "authenticated"));
} else {
    $util->webhook($util->getIP() . " Tried accessing but key was expired", true, $data, 2);
    echo json_encode(array("message" => "sorry but your expired", "code" => 43983));
    exit;
}
//$clients = 

