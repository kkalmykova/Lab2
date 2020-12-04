<?php
   // Start the session
    session_start();
    if ($_SESSION['auth'] == true){ // if user authentificated unconditional return
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    $email="";
    $password="";
    $lastbasequery="";
    $_SESSION['lastbasequery']="";
    $referer = $_SERVER['HTTP_REFERER'];
    if(isset($_POST['email']) && (isset($_POST['password']))){ 
        $email = $_POST['email'];
        $password = $_POST['password'];    
        $sql = "SELECT id, first_name, last_name, email, role_id, password FROM users WHERE email=\"".$email."\";";
        require_once 'connection.php';
        $result = mysqli_query($connect, $sql);
        mysqli_close($connect);
        if(($result != null) && (($person = mysqli_fetch_array($result)) != null)){
            if($person["password"] == $password ){
                $_SESSION['auth'] = true;
                $_SESSION['myid'] = $person['id'];
                $_SESSION['myfirst_name'] = $person['first_name'];
                $_SESSION['mylast_name'] = $person['last_name'];
                if ($person['role_id'] == 1)$_SESSION['admin'] = true;
                else $_SESSION['admin'] = false;
                $lastbasequery .= "Sign in successful. Welcome. ";
            } 
            else{
                //echo "entered: ".$password." from base:". $person["password"];
                $lastbasequery .= "Password incorrect. "; // repeat login process
            }
        }
        else{
             $lastbasequery .= "This email not found. "; // repeat login process
        }
    }
    else {
        $lastbasequery .= "Email or password was not entered. ";
    }
    $_SESSION['lastbasequery'] = $lastbasequery;
    header("location:".$referer);
   ?>
