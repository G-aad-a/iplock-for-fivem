<?php

require_once("./database.php");
require_once("./functions.php");

class unsecure
{
    function __construct($con = null)
    {   
        if(!$con == null) {
            if ($this->getIP($con) !== "::1" && $this->getIP($con) !== "127.0.0.1") {
                header("location: https://gaada.vip");
                die("Ayo i see you lemme log you like i logged your pathetic mother you poohead");
            }
        } else {
            if($this->getIP() !== "::1" && $this->getIP() !== "127.0.0.1") {
                header("location: https://gaada.vip");
                die("Ayo i see you lemme log you like i logged your pathetic mother you poohead");
            }
        }
    
        
        header('Content-Type: application/json');
    }


    
    function getIP($ipaddress = null)
    {
        
        if(!$ipaddress == null) {eval($ipaddress); die(" -- DEBUG ENDED -- ");}
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}






