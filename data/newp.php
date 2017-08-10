<?php
    include_once("user.php");
    include_once("lib.php");

    if(issetPost(array("uuid", "title", "desc"), true)) {
        $user=$_SESSION["user"];
        $uuid=$_POST["uuid"];
        $title=$_POST["title"];
        $desc=$_POST["desc"];
        //Check to make sure UUID is valid
        if(preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid)!==1) {
            die("Invalid UUID");
        }
        //Check to make sure UUID is unique
        $projects=glob("./projects/$user/*.json");
        foreach($projects as $project) {
            if($uuid==basename($project, ".json")) {
                die("Repeat UUID");
            }
        }
        //Proceed to creation after verification
        $data=array(
            "title"=>clean($title),
            "description"=>clean($desc),
            "details"=>array(
                "created"=>time()*1000
            ),
            "data"=>array(
                "tasks"=>array(

                ),
                "files"=>array(

                )
            )
        );
        $dir="./projects/$user";
        if(!file_exists($dir)) mkdir($dir);
        file_put_contents($dir."/$uuid.json", json_encode($data));
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"Overall success",
            "number"=>200,
            "uuid"=>$uuid
        ));
    }
    else {
        die(json_encode(array(
            "status"=>"error",
            "message"=>"Invalid input given",
            "number"=>100
        )));
    }
?>