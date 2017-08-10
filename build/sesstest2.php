<?php
    session_start();
    echo session_id();
    print_r($_SESSION);
    $sessionfile = '..' . ini_get('session.save_path') . '/' . 'sess_'.session_id();  
echo 'session file: ', $sessionfile, ' ';  
echo 'size: ', filesize($sessionfile), "\n";
?>