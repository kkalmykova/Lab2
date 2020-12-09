<?php  
    //Var_dump($_POST);
    if(isset($_POST['submit'])){// if form was sent ('submit' clicked)
        // this recurred nested operation when form calls itself
        // restores (by POST method)vars entered into form inputs 
        $referer = $_POST['referer']; // restores referer form info from POST data
        $btn_title = $_POST['submit']; // restores status of clicked button 'submit' title 'update'/'register'
        $id = $_POST['id'];            // restores 'form'(page) input field values    
        $first_name = $_POST['first_name'];    
        $last_name = $_POST['last_name'];
        $role_id = $_POST['role_id'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
//        if(isset($_SESSION['imageURL'])){
//            $imageURL = $_SESSION['imageURL'];
//            unset($_SESSION['imageURL']);
//        }
//      else 
        $imageURL = $_POST['imageURL'];
        $old_imageURL = $_POST['old_imageURL'];
        //'id' == 0 means new user then 'email' to be checked if not used
        if ($id == 0) { 
            $sql = "SELECT * FROM users WHERE email=\"".$email."\";";
            $result = mysqli_query($connect, $sql);
            if(($person = mysqli_fetch_array($result)) != null){  
                // result!=null means 'email' is in use
                $error = $error."That email is already signed up. ";
                $success = false;
            }
        }
        //checks passwords matching
        if($password != $password_confirm) {
            $error = $error."Passwords do not match. ";
            $success = false;
        }
        require_once 'saveuserdatascript.php'; //!!!!!!!!!!!!!!
    }    
