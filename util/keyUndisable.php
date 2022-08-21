<?php

require_once("./functions.php");

class undisable
{
    function __construct($key)
    {
        $this->key = $key;
        $this->util = new Utility();
        $this->db = $this->util->database;
    }

    function undisable()
    {
        $this->info = $this->db->query('SELECT * FROM `keys` WHERE `key` = ?', $this->key);

        if($this->info->numRows() > 0) {

            $this->infomation = $this->db->query('SELECT * FROM `keys` WHERE `key` = ? AND `disabled` = 1', $this->key);

            if($this->infomation->numRows() > 0) {
                $this->db->query('UPDATE `keys` SET `disabled` = 0 WHERE `key` = ?', $this->key);

                echo json_encode(array("message" => "done", "code" => 200));

            } else {
                echo json_encode(array("message" => "key is not disabled", "code" => 24839));
            }
        } else {
            echo json_encode(array("message" => "key does not exists", "code" => 24839));
        }
    }
}
