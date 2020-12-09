<?php
    $dbconnectionscript = 'connectionscript.php';
    session_start();
    //Var_dump($_POST);
    $referer = $_SERVER['HTTP_REFERER'];
    if(!isset($_POST['id'])){
        header("location: ".$referer);
    }
    else {
        $id = $_POST['id'];
        if(isset($_POST['submit'])){
            if ($_POST['submit'] == "Yes"){
                require_once $dbconnectionscript;
                $sql = "DELETE FROM users WHERE id=".$id.";";
                $Ok = mysqli_query($connect, $sql);
                mysqli_close($connect);
                if($Ok){ 
                    $lastbasequery = "Removal successful";   
                }        
                else {
                    $lastbasequery = "Removal unsuccessful";
                }    
                $_SESSION['lastbasequery'] = $lastbasequery;
            } 
        }        
    } 
   header("location: ".$referer);
?>