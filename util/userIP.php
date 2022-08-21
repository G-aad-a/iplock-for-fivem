<?php

require_once("./functions.php");

class ChangeIp {

    function __construct($Ip, $discord)
    {
        $this->Util = new Utility();
        $this->db = $this->Util->database;
        $this->Ip = $Ip;
        $this->key = $discord;
    }


    function ChangeIp() {
        $this->cb = $this->db->query("UPDATE `whitelisted` SET `ip` = ? WHERE `key` = ?", $this->Ip, $this->key)->affectedRows();
        
        if($this->cb <= 0) {
            echo json_encode(array("message" => "rows havent been affected", "code" => 29432));
            exit;
        } else {
            echo json_encode(array("message" => "rows have been affected", "code" => 299));
            exit;
        }
    }

}