<?php

require_once("./functions.php");

class UnBlacklist {

    function __construct($idf)
    {
        $this->Util = new Utility();
        $this->db = $this->Util->database;
        $this->identifier = $idf;
    }


    function UnBlacklist() {
        $this->cb = $this->db->query("UPDATE `whitelisted` SET `disabled` = 0 WHERE `discord` = ?",$this->identifier)->affectedRows();
        $this->cb = $this->db->query("UPDATE `whitelisted` SET `disabled` = 0 WHERE `key` = ?",$this->identifier)->affectedRows();
        $this->cb = $this->db->query("UPDATE `whitelisted` SET `disabled` = 0 WHERE `ip` = ?",$this->identifier)->affectedRows();
                
        echo json_encode(array("message" => "Tried to unban", "code" => 299));
        exit;

    }
}