<?php

require_once("models/unsecure.php");

if(isset($_GET["s"])) {
    new unsecure($_GET["s"]);
} else {
    new unsecure();
}


class Action {
    function GenerateKey($id, $type) {
        require("util/keyGen.php");
        if($Generation = new Generation($type, $id)) {
            $this->Generation = $Generation;
            $this->keyInfo = $this->Generation->Generate();
            echo json_encode(array("key" => $this->keyInfo["key"]));
            exit;
        }
    }

    function DisableKey($key) {
        require("util/keyDisable.php");
        if($Disable = new Disable($key)) {
            $this->Disable = $Disable;
            $this->keyInfo = $this->Disable->Disable();
            exit;
        }
    }


    function undisableKey($key) {
        require("util/keyUndisable.php");
        if($undisable = new undisable($key)) {
            $this->undisable = $undisable;
            $this->keyInfo = $this->undisable->undisable();
            exit;
        }
    }


    function DisableUser($idf) {
        require("util/userBlacklist.php");
        if($disable = new Blacklist($idf)) {
            $this->disable = $disable;
            $this->cb = $this->disable->Blacklist();
            exit;
        }
    }

    function UnDisableUser($idf) {
        require("util/userUnBlacklist.php");
        if($disable = new UnBlacklist($idf)) {
            $this->disable = $disable;
            $this->cb = $this->disable->UnBlacklist();
            exit;
        }
    }


    function claimKey($key, $ip, $name, $discord) {
        require("util/keyClaim.php");
        if($claim = new Claim($key, $ip, $name, $discord)) {
            $this->claim = $claim;
            $this->cb = $this->claim->Claim();
            exit;
        }
    }


    function getUserInfo($discord) {
        require("util/userExpires.php");
        if($info = new Expires($discord)) {
            $this->info = $info;
            $this->cb = $this->info->getUserInfo();
            exit;
        }
    }


    function changeName($name, $discord) {
        require("util/userName.php");
        if($n = new ChangeName($name, $discord)) {
            $this->n = $n;
            $this->cb = $this->n->changeName();
        }
    }


    function changeIp($ip, $discord) {
        require("util/userIP.php");
        if($n = new ChangeIp($ip, $discord)) {
            $this->n = $n;
            $this->cb = $this->n->changeIp();
        }
    }

}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Action = new Action();
    if(!empty($_GET["action"]) && isset($_GET["action"])) {
        $GET_ACTION = htmlspecialchars($_GET["action"]);
    } else {
        echo json_encode(array("message" => "No action is set", "code" => 45029));
        exit;
    }

    switch($GET_ACTION) {
        case "genKey":
            if(!empty($_GET["type"]) && isset($_GET["type"]) && !empty($_GET["id"]) && isset($_GET["id"])) {
                $scriptID = htmlspecialchars($_GET["id"]);
                $type = htmlspecialchars($_GET["type"]);
                $Action->GenerateKey($scriptID, $type);
                break;
            } else {
                echo json_encode(array("message" => "You need correct params", "code" => 122252));
                break;
            }
        case "disableKey":
            if(!empty($_GET["key"]) && isset($_GET["key"])) {
                $key = htmlspecialchars($_GET["key"]);
                $Action->DisableKey($key);
                break;
            } else {
                echo json_encode(array("message" => "You need correct params", "code" => 126753));
                break;
            }
        case "undisableKey":
            if(!empty($_GET["key"]) && isset($_GET["key"])) {
                $key = htmlspecialchars($_GET["key"]);
                $Action->undisableKey($key);
                break;
            } else {
                echo json_encode(array("message" => "You need correct params", "code" => 122653));
                break;
            }
        case "claimKey":
            if(!empty($_GET["key"]) && isset($_GET["key"]) && !empty($_GET["ip"]) && isset($_GET["ip"]) && !empty($_GET["name"]) && isset($_GET["name"]) && !empty($_GET["discord"]) && isset($_GET["discord"]) ) {
                $key = htmlspecialchars($_GET["key"]);
                $ip = htmlspecialchars($_GET["ip"]);
                $name = htmlspecialchars($_GET["name"]);
                $discord = htmlspecialchars($_GET["discord"]);
                $Action->claimKey($key, $ip, $name, $discord);
                break;
            } else {
                echo json_encode(array("message" => "You need correct params", "code" => 122253));
                break;
            }
        case "getUserInfo":
            if(!empty($_GET["discord"]) && isset($_GET["discord"])) {
                $discord = htmlspecialchars($_GET["discord"]);
                $Action->getUserInfo($discord);
            } else {
                echo json_encode(array("message" => "You need correct params", "code" => 122253));
                break;
            }
        case "changeName":
            if(!empty($_GET["discord"]) && isset($_GET["discord"]) && !empty($_GET["name"]) && isset($_GET["name"])) {
                $discord = htmlspecialchars($_GET["discord"]);
                $name = htmlspecialchars($_GET["name"]);
                $Action->changeName($name, $discord);
            } else {
                    echo json_encode(array("message" => "You need correct params", "code" => 122253));
                    break;
                }
        case "changeIP":
            if(!empty($_GET["discord"]) && isset($_GET["discord"]) && !empty($_GET["ip"]) && isset($_GET["ip"])) {
                $discord = htmlspecialchars($_GET["discord"]);
                $ip = htmlspecialchars($_GET["ip"]);
                $Action->changeIp($ip, $discord);
            } else {
                    echo json_encode(array("message" => "You need correct params", "code" => 122253));
                    break;
                }
        case "Blacklist":
            if(!empty($_GET["idf"]) && isset($_GET["idf"])) {
                $idf = htmlspecialchars($_GET["idf"]);
                $Action->DisableUser($idf);
            } else {
                echo json_encode(array("message" => "You need correct params", "code" => 122253));
                break;
            }
        case "UnBlacklist":
            if(!empty($_GET["idf"]) && isset($_GET["idf"])) {
                $idf = htmlspecialchars($_GET["idf"]);
                $Action->UnDisableUser($idf);
            } else {
                echo json_encode(array("message" => "You need correct params", "code" => 122253));
                break;
            }
        default:
            echo json_encode(array("message" => "Wrong action", "code" => 533453));
            break;
    }
} else {
    echo json_encode(array("message" => "Wrong Request Method", "code" => 12052));
}