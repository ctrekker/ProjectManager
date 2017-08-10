<?php
    session_start();
    include_once("lib.php");
    if(issetPost(array("first", "last", "email", "user", "pass"), true)) {
        $first = $_POST["first"];
        $last  = $_POST["last"];
        $email = $_POST["email"];
        $user  = $_POST["user"];
        $pass  = $_POST["pass"];

        $useruuid=md5($user);
        $user_path="./users/$useruuid.json";
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if(!file_exists($user_path)) {
                $user_data=array (
                    "first"=>clean($first),
                    "last"=>clean($last),
                    "email"=>clean($email),
                    "user"=>clean($user),
                    "pass"=>clean(sha1($pass)),
                    "passlen"=>clean(strlen($pass)),
                );
                file_put_contents($user_path, json_encode($user_data));
                //Create and write default profile image to apropriate slot
                copy("../static/img/avatar.png", "./img/profile/$useruuid.png");

                $_GET["include"]="true";
                ob_start();
                include_once("signin.php");
                ob_end_clean();
                out_message("ok", "Account successfully created", 200);
            }
            else {
                out_message("error", "Username already in use", 102);
            }
        }
        else {
            out_message("error", "Invalid email", 103);
        }
    }
    else {
        out_message("error", "Invalid input given", 100);
    }
?>