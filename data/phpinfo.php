<?php
    //phpinfo();
    $root=array ("a"=>array ("b"=>array ("c"=>array ("d"=>"Hi"))));

    $a=$root["a"];
    $b=$a["b"];
    $b["test"]="Hi there1";

    print_r($root);

    function array_insert($arr, $index, $val) {
        $start=array_slice($arr, 0, $index);
        $end=array_slice($arr, $index);
        
        return array_merge($start, array ($val), $end);
    }
?>