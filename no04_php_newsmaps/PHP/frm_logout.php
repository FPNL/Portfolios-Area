<?php

    //啟動Session
    session_start();

    //清除所有的Session
    session_destroy();
    
    header("Location: index.php"); 
?>