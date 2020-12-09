<?php
// if 'id' was not set for first call this means registration process (new user)
// otherwise this means data update process, Next iterations have 'id' because form calls itself
// if 'referer' not set it means first iteration (form call) next iterations will set 'referer'
    session_start();
    $edituserdata_form = "edituserdata.php";
    $upload_script = "uploadscript.php";
    $dbconnectionscript = "connectionscript.php";
    $logo_image = "internal/logo00.jpg";
    $no_imageURL = "internal/no-avatar.png";
    $id = 0;                //'id' field of this form (page) for currently processed user
    $first_name = "";       //'first_name' field of this form (page) for currently processed user
    $last_name = "";        //'last_name' field of this form (page) for currently processed user
    $role_id = 2;           //'role_id' field of this form (page) for currently processed user
    $email = "";            //'email' field of this form (page) for currently processed user
    $imageURL = "";            //'image' field of this form (page) for currently processed user
    $password = "";         //'password' field of this form (page) for currently processed user
    $password_confirm = ""; //'password_confirmed' field of this form (page) for currently processed user
    $old_imageURL = "";          //'oldimage' field of this form (page) used in uploading operations
    
    $success = true;        //flag of success operation and data correctness
    $error = "";            // keeps information on data entering error  
    $lastbasequery = "";    // keeps information on db operationd status
    $referer = "";          // keeps data on preferer (previous form)
    $btn_title = "Register";// by default this is 'Register'(new user) process and 'Register' title is set accordingly

    $auth = false;          //if user authrntificated
    $admin = false;         //if authentificated  user has admin role
    $mypage = false;        //if user is in own page
    $myfirst_name = "";     //keeps 'first_name' of authentificated  user
    $mylast_name = "";      //keeps 'first_name' of authentificated  user
    $myrole_id = 0;         //keeps 'role_id' of authentificated  user
    $myid = 0;              //keeps 'id' of authentificated  user

    $admin = false;
    $myuserdata = false;
    //firstly checks authentification vars and sets relevant environment
    if(isset($_SESSION['auth'])&&(isset($_SESSION['myid']))) {
        $auth = $_SESSION['auth'];
        $myid = $_SESSION['myid'];
        if(isset($_SESSION['admin'])) $admin = $_SESSION['admin']; 
    }
    else
        $_SESSION['auth'] = false;
    require_once $dbconnectionscript;    
    if(!isset($_POST['referer'])){ //if 'referer' not set this is first iteration
        $referer = $_SERVER['HTTP_REFERER'];// set 'referer'
        //if(isset($_SESSION['lastbasequery']))$lastbasequery = $_SESSION['lastbasequery'];
        if(isset($_POST['id'])){ // if 'referer' not set but 'id' set, it means db reading required
            $id = $_POST['id']; 
            $btn_title = "Update"; //and this is update request 
            $sql = "SELECT users.id, users.first_name, users.last_name, "
            . "roles.title, users.role_id, users.email, users.password, users.image "
            . "FROM users "
            . "LEFT JOIN roles "
            . "ON users.role_id = roles.id "
            . "WHERE users.id = ".$id.";";
            $result = mysqli_query($connect, $sql);
            if ($result != null){ //reads db and sets internal vars
                $person = mysqli_fetch_array($result);
                $first_name = $person['first_name'];    
                $last_name = $person['last_name'];
                $role_id = $person['role_id'];
                $email = $person['email'];
                $imageURL = $person['image'];
                $old_imageURL = $imageURL;
                //echo "image ".$image."  oldimage ".$old_image;
                $password = $person['password'];
            } 
        }
    }    
    else { //verifies data after first/next iteration and makes db operations
        require_once 'checkuserdatascript.php';
    }
    if($id == $myid) $mypage = true;        //checks if user is on own page
    $sql = "SELECT id, title FROM roles";   //prepares roles list
    $roles = mysqli_query($connect, $sql);
    mysqli_close($connect);
?>