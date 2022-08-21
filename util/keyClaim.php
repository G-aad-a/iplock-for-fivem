<?php

require_once("./functions.php");

class Claim
{
    function __construct($key, $ip = "not set", $serverName = "not set", $discord)
    {
        $this->discord = $discord;
        $this->ip = $ip;
        $this->name = $serverName;
        $this->key = $key;
        $this->util = new Utility();
        $this->db = $this->util->database;
    }

    function Claim()
    {
        $this->info = $this->db->query('SELECT * FROM `keys` WHERE `key` = ?', $this->key);

        if($this->info->numRows() > 0) {

            $this->infomation = $this->db->query('SELECT * FROM `keys` WHERE `key` = ? AND `used` = 0 LIMIT 1', $this->key);

            if($this->infomation->numRows() > 0) {
                $this->ass = $this->infomation->fetchArray();
                $this->util->createWhitelist($this->ip, $this->key, $this->name, $this->ass["type"], $this->ass["script_id"], $this->discord);

            } else {
                echo json_encode(array("message" => "key is already used", "code" => 23435));
            }
        } else {
            echo json_encode(array("message" => "key does not exists", "code" => 248339));
        }
    }
}
