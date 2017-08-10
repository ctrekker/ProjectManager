<?php
    header("Content-type: application/json");
    include_once("user.php");

    if(isset($_POST["uuid"])&&isset($_SESSION["user"])) {
        $user=$_SESSION["user"];
        $uuid=$_POST["uuid"];
        if($uuid==="LIST") {
            $projects=glob("./projects/$user/*.json");
            $uuid_list=array();
            foreach($projects as $project) {
                $uuid_list[]=basename($project, ".json");
            }
            echo json_encode($uuid_list);
        }
        else {
            $prj_data=json_decode(file_get_contents("./projects/$user/$uuid.json"), true);
            $prj_data["uuid"]=$uuid;
            echo json_encode($prj_data);
        }
    }
?>