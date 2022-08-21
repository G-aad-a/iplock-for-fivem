<?php

require_once("./functions.php");

class ChangeName {

    function __construct($name, $discord)
    {
        $this->Util = new Utility();
        $this->db = $this->Util->database;
        $this->name = $name;
        $this->key = $discord;
    }


    function ChangeName() {
        $this->cb = $this->db->query("UPDATE `whitelisted` SET `servername` = ? WHERE `key` = ?", $this->name, $this->key)->affectedRows();
        
        if($this->cb <= 0) {
            echo json_encode(array("message" => "rows havent been affected", "code" => 29432));
            exit;
        } else {
            echo json_encode(array("message" => "rows have been affected", "code" => 299));
            exit;
        }
    }

}