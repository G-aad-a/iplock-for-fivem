<?php

require_once("./functions.php");

class Blacklist {

    function __construct($idf)
    {
        $this->Util = new Utility();
        $this->db = $this->Util->database;
        $this->identifier = $idf;
    }


    function Blacklist() {
        $this->cb = $this->db->query("UPDATE `whitelisted` SET `disabled` = 1 WHERE `discord` = ?",$this->identifier)->affectedRows();
        
        if($this->cb > 0) {
            echo json_encode(array("message" => "rows have been affected", "code" => 299));
            exit;
        } else {
            $this->cb = $this->db->query("UPDATE `whitelisted` SET `disabled` = 1 WHERE `key` = ?",$this->identifier)->affectedRows();
            
            if($this->cb > 0) {
                echo json_encode(array("message" => "rows havent been affected", "code" => 299));
                exit;
            } else {
                $this->cb = $this->db->query("UPDATE `whitelisted` SET `disabled` = 1 WHERE `ip` = ?",$this->identifier)->affectedRows();
                if($this->cb > 0) {
                    echo json_encode(array("message" => "rows havent been affected", "code" => 299));
                    exit;
                } else {
                    echo json_encode(array("message" => "rows havent been affected", "code" => 29432));
                    exit;
                }
            }
        }
    }
}