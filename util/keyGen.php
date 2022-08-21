<?php

require_once("./functions.php");

class Generation {
    function __construct($type, $id, $expires = null)
    {
        $this->util = new Utility();
        $this->key = $this->util->generateRandomString();
        $this->type = $type;
        $this->id = $id;
        $this->db = $this->util->database;
    }

    function Generate()
    {
        switch(strtoupper($this->type)) {
            case  "LIFETIME":
                $this->type = "LIFETIME";
            break;
            case "MONTH":
                $this->type = "MONTH";
            break;
            case "WEEK":
                $this->type = "WEEK";
            break;
            case "DAY":
                $this->type = "DAY";
            break;
            default:
                echo json_encode(array("message" => "This type does not exists", "code" => "12005"));
                exit;
            break;
        }

        //die($this->id); -- DEBUG PRINT
        $this->db->query("INSERT INTO `keys` (`key`, `type`, `script_id`) VALUES (?, ?, ?)", $this->key, $this->type, $this->id);
        return array("key" => $this->key);
    }
}