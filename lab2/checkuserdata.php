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
        if(isset($_SESSION['image'])){
            $image = $_SESSION['image'];
            unset($_SESSION['image']);
        }
        else $image = $_POST['image'];
        $old_image = $_POST['old_image'];
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
        require_once 'saveuserdata.php'; //!!!!!!!!!!!!!!
    
    /*    
        if($success) {  
            if($id == 0) { // new user to be inserted
                $sql = "INSERT INTO users (id, first_name, last_name, "
                        ."role_id, email, password, image) "
                        ."VALUES (NULL,"
                        ." \"".$first_name."\","
                        ." \"".$last_name."\","
                        ." ".$role_id.","
                        ." \"".$email."\","
                        ." \"".$password."\","
                        ." \"".$image."\");";                
                $Ok = mysqli_query($connect, $sql);
                mysqli_close($connect);
                if($Ok){ 
                    $lastbasequery = "Registration successful. Use login form to enter";
                    //keeps status of last db operation
                    $_SESSION['lastbasequery'] = $lastbasequery;
                    header("location: ".$referer); //if Ok go to 'login' form
                }        
                else {
                    $lastbasequery = "Registration unsuccessful\n Try again";
                    //keeps status of last db operation
                    $_SESSION['lastbasequery'] = $lastbasequery;
                    //if not Ok stays here 'in dataedit' form
                }                
            }
            else {
                $sql = "UPDATE users SET "
                    ."first_name=\"".$first_name."\", "
                    ."last_name=\"".$last_name."\", "
                    ."role_id=".$role_id.", "
                    ."email=\"".$email."\", "
                    ."image=\"".$image."\", "
                    ."password=\"".$password."\" "
                    ."WHERE id=".$id.";";
                //echo $sql;
                $Ok = mysqli_query($connect, $sql);
                mysqli_close($connect);
                if($Ok){ 
                   $lastbasequery = "Update successful";
                }        
                else {
                    $lastbasequery = "Update unsuccessful";
                }    
                //$lastbasequery.="image=". $image."  \n  oldimage=".$oldimage;
                $_SESSION['lastbasequery'] = $lastbasequery;
                if(isset($_SESSION['auth']) && isset($_SESSION['myid']) && ($_SESSION['myid'] == $id)){
                    $_SESSION['myfirst_name'] = $first_name;
                    $_SESSION['mylast_name'] = $last_name;
                    $_SESSION['myrole'] = $role_id;
                }
                //returns on previous(referer) form and keeps status of last db operation
                 
                if(($image != $old_image)&&($old_image != "")) unlink($old_image); // clears disk space by removal old image
                header("location: ".$referer);
            }
        }   
        else {
            $error = $error."Please, enter data again";
        }*/
    }     
?>