<?php
    session_start();
    echo session_id();
    $_SESSION["test"]="Hello!";
    print_r($_SESSION);
    echo "<br>";
    echo __DIR__;
    session_write_close();
?>
<a href="sesstest2.php">Test Session</a>