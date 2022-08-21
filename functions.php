<?php


class Utility
{

    function __construct()
    {
        require_once('database.php');
        $this->config = include('config.php');
        $this->database = new db();
    }

    function timeTypeGenerator($type)
    {
        $start = date('Y-m-d');
        if ($type === "lifetime" || $type === "LIFETIME") {
            return date('Y-m-d', strtotime('+1000 year', strtotime($start)));
        } elseif ($type === "month" ||  $type === "MONTH") {
            return date('Y-m-d', strtotime('+1 month', strtotime($start)));
        } elseif ($type === "week" || $type === "WEEK") {
            return date('Y-m-d', strtotime('+1 week', strtotime($start)));
        } else {
            echo json_encode(array("code" => 500, "resp" => "WRONG_TYPE_SELECTED"));
        }
    }

    function generateRandomString($length = 20)
    {
        $characters = 'ABCDEFGVXC';
        $charactersLength = strlen($characters);
        $randomString =  $this->config->Key_Start_Name;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function strToHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0' . $hexCode, -2);
        }
        return strToUpper($hex);
    }

    function getIP()
    {
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


    function createWhitelist($ip, $key, $name, $type, $script_id, $discord)
    {
        //die($type);
        $this->check = $this->database->query("SELECT * FROM `whitelisted` WHERE `discord` = ? AND `script_id` = ?", $discord, $script_id)->numRows();
        if ($this->check <=  0) {

            $this->expires = $this->timeTypeGenerator($type);
            $this->database->query('UPDATE `keys` SET `used` = 1 WHERE `key` = ?', $key);
            $this->database->query("INSERT INTO `whitelisted` (`script_id`, `ip`, `servername`, `discord`, `expires`,  `key`) VALUES (? , ? , ? , ? , ? , ?)", $script_id, $ip, $name, $discord, $this->expires, $key);
            echo json_encode(array("message" => "done", "code" => 200));
        } else {
            echo json_encode(array("message" => "already have an acc", "code" => 49329));
            exit;
        }
    }

    function getBannedIps($ip)
    {
        $banned = $this->database->query("SELECT * FROM banned WHERE `ip` = ?", $ip);
        echo $banned["ip"];
    }

    public function webhook($msg, $fail, $data = "NOT PROVIDED :/", $r = 0)
    {
        $timestamp = date("c", strtotime("now"));
        
        if($data != "NOT PROVIDED :/") {
            $data = json_decode($data, false);
            $key = $data->licenseKey;
            $res = $data->ResourceName;
            $steam = $data->steamApiKey;
            $name = $data->serverName;
        } else {
            $key = "N/A";
            $res = "N/A";
            $steam = "N/A";
            $name = "N/A";
        }

        if($fail == true) {
            $json_data = json_encode([
                "username" => "IPLOCK",
                "embeds" => [
                    [
                        "title" => "IPLOCK LOGS",
                        "type" => "rich",
                        "description" => "IPLOCK -> " . $msg,
                        "timestamp" => $timestamp,
                        "color" => hexdec("#FF0000"),
    
                        // Footer
                        "footer" => [
                            "text" => "Github.com/G-aad-a",
                            "icon_url" => "https://avatars.githubusercontent.com/u/68150467?v=4"
                        ],
                        "author" => [
                            "name" => "Mr. Gade",
                            "url" => "https://Github.com/G-aad-a/"
                        ],
                        "fields" => [
                            [
                                "name" => "licenseKey",
                                "value" => $key,
                                "inline" => false
                            ],
                            [
                                "name" => "ResourceName",
                                "value" => $res,
                                "inline" => false
                            ],
                            [
                                "name" => "steamApiKey",
                                "value" => $steam,
                                "inline" => false
                            ],
                            [
                                "name" => "serverName",
                                "value" => $name,
                                "inline" => false
                            ],
                        ]
                    ]
                ]
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
            $json_data = json_encode([
                "username" => "IPLOCK",
                "embeds" => [
                    [
                        "title" => "IPLOCK LOGS",
                        "type" => "rich",
                        "description" => "IPLOCK -> " . $msg,
                        "timestamp" => $timestamp,
                        "color" => hexdec("#00FF00"),
    
                        // Footer
                        "footer" => [
                            "text" => "Github.com/G-aad-a",
                            "icon_url" => "https://avatars.githubusercontent.com/u/68150467?v=4"
                        ],
                        "author" => [
                            "name" => "Mr. Gade",
                            "url" => "https://Github.com/G-aad-a/"
                        ],
                        "fields" => [
                            [
                                "name" => "licenseKey",
                                "value" => $key,
                                "inline" => false
                            ],
                            [
                                "name" => "ResourceName",
                                "value" => $res,
                                "inline" => false
                            ],
                            [
                                "name" => "steamApiKey",
                                "value" => $steam,
                                "inline" => false
                            ],
                            [
                                "name" => "serverName",
                                "value" => $name,
                                "inline" => false
                            ],
                        ]
                    ]
                ]
    
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        
        //die($this->config->Webhook);

        if($r == 0) {
            $ch = curl_init($this->config->NotAllowed_Web);
        } elseif ($r == 1) {
            $ch = curl_init($this->config->WrongKey_Web);
        } elseif($r == 2) {
            $ch = curl_init($this->config->Expired_Web);
        } elseif($r == 3) {
            $ch = curl_init($this->config->Success_Web);
        } elseif($r == 4) {
            $ch = curl_init($this->config->Disabled_Web);
        }

        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_exec($ch);
        curl_close($ch);
    }
}
