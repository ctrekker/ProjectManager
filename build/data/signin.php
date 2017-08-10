<?php
    if(!isset($_GET["include"])) session_start();
    include_once("lib.php");
    if(!isset($_SESSION["user"])) {
        if(issetPost(array("user", "pass"), true)) {
            $user=$_POST["user"];
            $pass=$_POST["pass"];
            $useruuid=md5($user);
            $user_path="./users/$useruuid.json";
            if(file_exists($user_path)) {
                $user_data=json_decode(file_get_contents($user_path), true);
                if(sha1($pass)==$user_data["pass"]) {
                    $_SESSION["user"]=$useruuid;
                    $_SESSION["ip"]=$_SERVER["REMOTE_ADDR"];
                    echo json_encode(array(
                        "status"=>"ok",
                        "message"=>"Signin successfull",
                        "number"=>200
                    ));
                }
                else {
                    echo json_encode(array(
                        "status"=>"error",
                        "message"=>"Invalid credentials",
                        "number"=>101
                    ));
                }
            }
            else {
                echo json_encode(array(
                    "status"=>"error",
                    "message"=>"Invalid credentials",
                    "number"=>101
                ));
            }
        }
        else {
            echo json_encode(array(
                "status"=>"error",
                "message"=>"Invalid input given",
                "number"=>100
            ));
        }
    }
    else {
        echo json_encode(array(
            "status"=>"error",
            "message"=>"Already signed in",
            "number"=>102
        ));
    }
?>