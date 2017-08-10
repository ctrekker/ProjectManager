<?php
    session_start();
    
    $included=count(get_included_files())>1;
    if($included) ob_start();
    if(isset($_SESSION["user"])&&isset($_SESSION["ip"])) {
        if(isset($_GET["get"])) {
            $user_data=json_decode(file_get_contents("./users/".$_SESSION["user"].".json"), true);
            unset($user_data["pass"]);
            echo json_encode($user_data);
        }
        else if(isset($_GET["img"])) {
            header("Content-type: ".image_type_to_mime_type(exif_imagetype("./img/profile/".$_SESSION["user"].".ppic")));
            echo file_get_contents("./img/profile/".$_SESSION["user"].".ppic");
        }
        else echo "true";
    }
    else echo "false";
    if($included) ob_end_clean();
?>