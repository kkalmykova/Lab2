<?php
    session_start();
    $_SESSION['auth'] = false;
    $_SESSION['admin'] = false;
    if (isset($_SESSION['image'])) unset($_SESSION['image']); //clears image uploading operation if was done 
    $_SESSION['myid'] = 0;
    $_SESSION['myfirst_name'] = "";
    $_SESSION['mylast_name'] = "";
    $_SESSION['myrole'] = 0;
    $_SESSION['lastbasequery'] = "User logout";
    header("location:".$_SERVER['HTTP_REFERER']);
?>