<?php
    session_start();
    $logo_image = "internal/logo00.jpg";
    $no_imageURL = "internal/no-avatar.png";
    $first_nameSVG = "internal/person-24px.svg";
    $last_nameSVG = "internal/person_outline-24px.svg";
    $emailSVG = "internal/email-24px.svg";
    $titleSVG = "internal/safety_divider-24px.svg";
    $imageSVG = "internal/portrait-24px.svg";
    $removeSVG = "internal/delete-24px.svg";
    $removeuserSVG = "internal/person_remove-24px.svg";
    $adduserSVG = "internal/person_add-24px.svg";
    $edituserSVG = "internal/contact_page-24px.svg";
    $signinSVG = "internal/login-24px.svg";
    
    $dbconnectionscript = "connectionscript.php";
    $edituserdata_form = "edituserdata.php"; // 'edituserdata' form file
    $adduserdata_form = "edituserdata.php";  // w/o POST[id'] acts as 'register' form 
    $signin_script = "checkusercredentialsscript.php"; //'login' script file
    $signout_form = "logoutscript.php";             // 'logout' script file   
    $deleteuserscript = "deleteuserscript.php"; // 'deleteuserdats' script file   
    $lastbasequery = "";    //keeps information on db operationd status
    $auth = false;          //if user authrntificated
    $admin = false;         //if authentificated  user has admin role
    
    $myfirst_name = "";     //keeps 'first_name' of authentificated  user
    $mylast_name = "";      //keeps 'first_name' of authentificated  user
    $myrole_id = 0;         //keeps 'role_id' of authentificated  user
    $myid = 0;              //keeps 'id' of authentificated  user
    
    require_once $dbconnectionscript;
    $sql = "SELECT users.id, users.first_name, users.last_name, users.email, users.role_id, roles.title, users.image ".
           "FROM users LEFT JOIN roles ".
           "ON users.role_id=roles.id;";
    $result = mysqli_query($connect, $sql);
    mysqli_close($connect);
    if (isset($_SESSION['image'])) unset($_SESSION['image']); //clears image uploading operation if was done 
    if(isset($_SESSION['lastbasequery']))$lastbasequery = $_SESSION['lastbasequery'];
    if(isset($_SESSION['auth'])&&(isset($_SESSION['myid']))) {
        $auth = $_SESSION['auth'];
        $myid = $_SESSION['myid'];
        if(isset($_SESSION['myfirst_name']))$myfirst_name = $_SESSION['myfirst_name'];
        if(isset($_SESSION['mylast_name']))$mylast_name = $_SESSION['mylast_name'];
        if(isset($_SESSION['admin'])) $admin = $_SESSION['admin'];
    }
    else
        $_SESSION['auth'] = false;
?>
