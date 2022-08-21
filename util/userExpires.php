<?php
require_once("./functions.php");


class Expires {
    function __construct($discord)
    {
        $this->discord = $discord;
        $this->Util = new Utility();
        $this->db = $this->Util->database;
    }


    function getUserInfo() {
        $this->info = $this->db->query("SELECT * FROM `whitelisted` WHERE `discord` = ? ", $this->discord)->fetchAll();

        if($this->db->query("SELECT * FROM `whitelisted` WHERE `discord` = ?", $this->discord)->numRows() > 0) {
            echo json_encode(array("content" => $this->info));
        } else {
            echo json_encode(array("message" => "your not whitelisted", "code" => 34928));
        }
    }
}