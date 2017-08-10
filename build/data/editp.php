<?php
    include_once("user.php");
    include_once("lib.php");
    if(isset($_SESSION["user"])) {
        /*
        UUID: The unique id of the desired project
        TARGET: The target edit algorithm to be used
        DATA: A serialized JSON object containing all information
        required in the target edit/save algorithm
        */
        if(issetPost(array("uuid", "target", "data"), true)) {
            $user=$_SESSION["user"];
            $uuid=$_POST["uuid"];
            $target=$_POST["target"];
            $new_data=json_decode($_POST["data"], true);
            $f_data_path="./projects/$user/$uuid.json";
            $f_data=json_decode(file_get_contents($f_data_path), true);
            if($target=="general") {
                foreach($new_data as $key=>$value) {
                    if(isset($f_data[$key])&&$key!="data"&&key!="details") {
                        $f_data[$key]=clean($value);
                    }
                    else out_message("error", "Invalid key name used", 110);
                }
            }
            else if($target=="tasks") {
                if($new_data["action"]=="new") {
                    $path_arr;
                    
                    if(!isset($new_data["parent"])) {
                        $new_data["parent"]="root";
                    }
                    else {
                        $path_arr=explode("-", $new_data["parent"]);
                    }
                    
                    if(!isset($new_data["index"])) {
                        if($new_data["parent"]=="root") {
                            $new_data["index"]=count($f_data["data"]["tasks"]);
                        }
                        else {
                            $new_data["index"]=(int)count(tasks_path_get($f_data["data"]["tasks"], $path_arr)["tasks"]);
                        }
                    }
                    if(!empty(clean($new_data["data"]["name"]))) {
                        $task=array (
                            "name"=>clean($new_data["data"]["name"]),
                            "description"=>clean($new_data["data"]["description"]),
                            "complete"=>$new_data["data"]["complete"],
                            "create_date"=>$new_data["data"]["create_date"],
                            "due_date"=>$new_data["data"]["due_date"],
                            "priority"=>clean($new_data["data"]["priority"]),
                            "tasks"=>array ()
                        );
                        if($new_data["parent"]=="root") {
                            $f_data["data"]["tasks"]=array_insert($f_data["data"]["tasks"], $new_data["index"], $task);
                        }
                        else {
                            $f_data["data"]["tasks"]=tasks_path_push($f_data["data"]["tasks"], $path_arr, $task, $new_data["index"]);
                        }
                        $task["path"]=str_replace("root-", "", $new_data["parent"]."-".$new_data["index"]);
                        echo json_encode($task);
                    }
                    else out_message("error", "name field empty", 112);
                }
                else if($new_data["action"]=="edit") {
                    $path_arr;
                
                    $path_arr=explode("-", $new_data["uuid"]);

                    $changed_data=tasks_path_get($f_data["data"]["tasks"], $path_arr);
                    foreach($new_data["data"] as $key=>$value) {
                        if($key!="tasks") {
                            $changed_data[$key]=$value;
                        }
                    }
                    $f_data["data"]["tasks"]=tasks_path_set($f_data["data"]["tasks"], $path_arr, $changed_data);
                }
                else if($new_data["action"]=="delete") {
                    $path_arr=explode("-", $new_data["uuid"]);
                    foreach($path_arr as $key=>$val) {
                        $path_arr[$key]=intval($val);
                    }

                    $out=tasks_path_get($f_data["data"]["tasks"], $path_arr);
                    $out["path"]=implode("-", $path_arr);

                    $f_data["data"]["tasks"]=tasks_path_delete($f_data["data"]["tasks"], $path_arr);

                    echo json_encode($out);
                }
            }
            else if($target=="files") {

            }
            file_put_contents($f_data_path, json_encode($f_data));
        } else out_message("error", "Bad request", 110);
    }
    else out_message("error", "Not logged in", 110);;
?>