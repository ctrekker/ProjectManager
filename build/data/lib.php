<?php
    function issetPost($arr, $empty_as_undef) {
        foreach($arr as $val) {
            if(!isset($_POST[$val])) return false;
            if($empty_as_undef&&empty($_POST[$val])) return false;
        }
        return true;
    }
    function clean($var) {
        $var=htmlspecialchars(trim($var));
        return $var;
    }
    function out_message($status, $message, $number) {
        echo json_encode(array(
            "status"=>$status,
            "message"=>$message,
            "number"=>$number
        ));
    }
    function array_insert($arr, $index, $val) {
        $start=array_slice($arr, 0, $index);
        $end=array_slice($arr, $index);
        
        return array_merge($start, array ($val), $end);
    }
    function tasks_path_get($arr, $path) {
        if(count($path)>1) return tasks_path_get($arr[$path[0]]["tasks"], array_slice($path, 1));
        else return $arr[$path[0]];
    }
    function tasks_path_push($arr, $path, $value, $index) {
        if(count($path)>1) {
            $arr[$path[0]]["tasks"]=tasks_path_push($arr[$path[0]]["tasks"], array_slice($path, 1), $value, $index);
        }
        else {
            $arr[$path[0]]["tasks"]=array_insert($arr[$path[0]]["tasks"], $index, $value);
        }
        return $arr;
    }
    function tasks_path_set($arr, $path, $value) {
        if(count($path)>2) {
            $arr[$path[0]]["tasks"]=tasks_path_set($arr[$path[0]]["tasks"], array_slice($path, 1), $value);
        }
        else if(count($path)==2) {
            $arr[$path[0]]["tasks"][$path[1]]=$value;
        }
        else {
            $arr[$path[0]]=$value;
        }
        return $arr;
    }
    function tasks_path_delete($arr, $path) {
        if(count($path)>1) {
            $arr[$path[0]]["tasks"]=tasks_path_delete($arr[$path[0]]["tasks"], array_slice($path, 1));
        }
        else {
            unset($arr[$path[0]]);
            $arr=array_values(array_filter($arr));
        }
        return $arr;
    }
?>