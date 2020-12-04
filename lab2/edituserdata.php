<?php
// if 'id' was not set for first call this means registration process (new user)
// otherwise this means data update process, Next iterations have 'id' because form calls itself
// if 'referer' not set it means first iteration (form call) next iterations will set 'referer'
    session_start();
    $edituserdata_form = "edituserdata.php";
    $upload_script = "upload.php";
    $logo_image = "logo00.jpg";
    $id = 0;                //'id' field of this form (page) for currently processed user
    $first_name = "";       //'first_name' field of this form (page) for currently processed user
    $last_name = "";        //'last_name' field of this form (page) for currently processed user
    $role_id = 2;           //'role_id' field of this form (page) for currently processed user
    $email = "";            //'email' field of this form (page) for currently processed user
    $image = "";            //'image' field of this form (page) for currently processed user
    $password = "";         //'password' field of this form (page) for currently processed user
    $password_confirm = ""; //'password_confirmed' field of this form (page) for currently processed user
    $old_image = "";          //'oldimage' field of this form (page) used in uploading operations
    
    $success = true;        //flag of success operation and data correctness
    $error = "";            // keeps information on data entering error  
    $lastbasequery = "";    // keeps information on db operationd status
    $referer = "";          // keeps data on preferer (previous form)
    $btn_title = "Register";// by default this is 'Register'(new user) process and 'confirm' title is set accordingly

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
    require_once 'connection.php';    
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
                $image = $person['image'];
                $old_image = $image;
                //echo "image ".$image."  oldimage ".$old_image;
                $password = $person['password'];
            } 
        }
    }    
    else { //verifies data after first/next iteration and makes db operations
        require_once 'checkuserdata.php';
    }
    if($id == $myid) $mypage = true;        //checks if user is on own page
    $sql = "SELECT id, title FROM roles";   //prepares roles list
    $roles = mysqli_query($connect, $sql);
    mysqli_close($connect);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        .container {
            width: 70%;
        }
    </style>
</head>
<body style="padding-top: 0rem;" class="center">
    <div class="container">
    <section>    
          <header class="header" style="padding: 0; margin: 0; background: gray; color:white">
              <h4>User information</h4></header>    
    </section>
    </div>
    <div class="container row">
        <section class="left">
            <img src="<?php echo $logo_image ?>" height="75" style="margin: 0; padding: 0">
        </section>
    <section class="col s6 right" style="margin: 0; padding:0">    
        <?php echo ($error != "") ? $error : " "; ?><br>    <!--shows error status of previous data entering iteration-->
        <?php echo ($lastbasequery != "") ? $lastbasequery : " "; ?><br> <!--shows status of last db operation-->
    </section>       
    </div>    
    <div class="container row">
        <div class="col s4 left" >
        <iframe id="imageframe"  srcdoc="<img src='<?php echo $image?>' 
                style='position: absolute; top: 0; left: 0; bottom: 0; right: 0; 
                margin: auto; margin-bottom: 0; width: 100%;'>" 
                name="imageframe" height="350" width="250" frameborder="no">    
        </iframe> 
        <!--<section class="col s4 offset-s4">-->
        <section style="position: relative; left: 40%">
        <?php 
            if (($admin && $auth)|| $mypage) {
                echo"<form enctype=\"multipart/form-data\" action=\"".$upload_script."\" method=\"post\" "
                . "name=\"loadphoto\" target=\"imageframe\">";
                echo"<div class=\"file-field input-field\">";
                echo"<div class=\"btn\">";
                echo"<span>Browse</span>";
                echo"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1024000\">";
                echo"<input class=\"center\" id=\"fileToUpload\" name=\"fileToUpload\" onchange=\"submit();\" "
                . "type=\"file\" accept=\".jpg,.pgn,.jpeg\">";
                echo"</div>";
               // echo"<div class=\"file-path-wrapper\">";
               // echo"<input class=\"file-path validate\" width= \"100\" type=\"text\"";
               // echo"placeholder = \"Upload image file\" />";
               // echo"</div>";
                echo"</div>";
                echo"</form>";
            }   
        ?>
       </section> 
    </div>
    <section class="col s6 right" >
    <form  action=<?php echo $edituserdata_form?> method="post">
        <div class="input-field">
            <input placeholder="First name"  
                value="<?php echo $first_name?>" type="text" name="first_name" 
                <?php if((!$admin || !$auth) && !$mypage) echo"disabled"?>>
            <!--if not admin AND not own user page read-only access allowed-->
            <label for="first_name" class="active">First name</label>
        </div>
        <div class="input-field">
            <input placeholder="Last name" 
                   value="<?php echo $last_name?>" type="text" name="last_name" 
                    <?php if((!$admin || !$auth) && !$mypage) echo"disabled"?>>
            <!--if not admin AND not own user page read-only access allowed-->
            <label for="last_name" class="active">Last Name</label>
        </div>
        <div class="input-field">  
            <select class="browser-default" name="role_id"
                    <?php if((!$admin || !$auth) || $mypage) echo"disabled"?>>
            <!--if not admin OR own user page read-only access allowed-->
            <?php
                if ($roles != null){
                    while($role = mysqli_fetch_array($roles)){
                        echo"<option value=\"".$role['id']."\"";
                        if ($role['id'] == $role_id){
                            echo"selected>";
                        }    
                        else {
                            echo">";
                        }    
                        echo$role['title']."</option>";
                    }
                }
                ?> 
            </select>   
            <label for="role_id" class="active">Title</label>
        </div>   
        <div class="input-field">
            <input placeholder="Email" 
                value="<?php echo $email?>" type="email" name="email" 
                 <?php if((!$admin || !$auth) && !$mypage) echo"disabled"?>>
            <!--if not admin AND not own user page read-only access allowed-->
            <label for="Email" class="active">Email</label>
        </div>    
        <?php
            if (($admin && $auth)|| $mypage) { // only admins and data owners are allowed to change this data
                echo"<div class=\"input-field\">";
                echo"<input placeholder=\"Password\" "; 
                echo"value=\"".$password."\" type=\"password\" "; 
                echo"name=\"password\" minlength=\"6\" required>";
                echo"<label for=\"password\" class=\"active\">Password</label>";
                echo"</div>";
                
                echo"<div class=\"input-field\">";
                echo"<input placeholder=\"Confirm password\" "; 
                echo"value=\"".$password_confirm."\" type=\"password\" "; 
                echo"name=\"password_confirm\" minlength=\"6\" required>";
                echo"<label for=\"Confirm_password\" class=\"active\">Confirm password</label>";
                echo"</div>";
                
                echo"<div>"; 
                //<!--hidden inputs to keep and POST service information-->
                echo"<input value=\"".$id."\" type=\"hidden\" name=\"id\">";
                echo"<input value=\"".$image."\" type=\"hidden\" name=\"image\">";
                echo"<input value=\"".$referer."\" type=\"hidden\" name=\"referer\">";
                echo"<input value=\"".$old_image."\" type=\"hidden\" name=\"old_image\">";
                echo"</div>";
                echo"<input type=\"submit\" name=\"submit\" value=\"".$btn_title."\" class=\"btn\">";
            }
         ?>
    <!--</form>    
    <form  action="edituserdata.php" method="post">-->
        <a class="btn" href ="<?php echo $referer?>">Cancel</a>
        <!--<input type="hidden" name=referer" value="<?php echo $referer?>">-->
        <!--<input type="submit" name="cancel" value="Cancel" class="btn" >-->
    </form>    
    </div>     
</body>
</html>