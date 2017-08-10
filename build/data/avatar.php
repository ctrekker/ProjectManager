<?php
    include_once("user.php");
    include_once("lib.php");

    $target_dir="./img/profile/";
    $target_file=$target_dir.$_SESSION["user"].".ppic";
    $uploadOk=true;
    $imageFileType=pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION);

    if(isset($_POST["submit"])) {
        if($_FILES["avatar"]["size"]>50000000) {
            $uploadOk=false;
            out_message("error", "File is larger than 50MB", 103);
        }
        if(empty($_FILES["avatar"]["tmp_name"])) {
            out_message("error", "No file to upload was present", 106);
            die();
        }
        $check=getimagesize($_FILES["avatar"]["tmp_name"]);
        if($check===false) {
            $uploadOk=false;
        }
    }

    if(strtolower($imageFileType)!="png"&&strtolower($imageFileType)!="jpg"&&strtolower($imageFileType)!="jpeg"&&strtolower($imageFileType)!="gif") {
        $uploadOk=false;
        out_message("error", "File type not supported. Supported types are PNG, JPG, JPEG, and GIF.", 104);
    }

    if($uploadOk) {
        if(file_exists($target_file)) {
            unlink($target_file);
        }
        if(move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            out_message("ok", "File has been uploaded and profile picture has been changed!", 200);
        }
        else {
            out_message("error", "An error occured while attempting to upload.", 105);
        }
    }
?>