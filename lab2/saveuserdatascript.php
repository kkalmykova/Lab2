<?php
if($success) {  
    if($id == 0) { // new user to be inserted
        // prepares filename for moving image file from 'temp/' to'images/' 
        if($imageURL != "") $storedimageURL = movingfilename($imageURL);
        //also checks if image was not changed keeps the same file (here is empty)
        else $storedimageURL = $imageURL;
        $sql = "INSERT INTO users (id, first_name, last_name, "
                        ."role_id, email, password, image) "
                        ."VALUES (NULL,"
                        ." \"".$first_name."\","
                        ." \"".$last_name."\","
                        ." ".$role_id.","
                        ." \"".$email."\","
                        ." \"".$password."\","
                        ." \"".$storedimageURL."\");";                
        $Ok = mysqli_query($connect, $sql);
        mysqli_close($connect);
        if($Ok){ 
            $lastbasequery = "Registration successful. Use login form to enter.";
            //keeps status of last db operation
            if($imageURL != "") 
                if(rename($imageURL,$storedimageURL)) { // moves image fiile from 'temp/' to 'images/'
                    $lastbasequery .= " Image file saved.";
            }    
            else $lastbasequery .= " Image file not saved. ";
            $_SESSION['lastbasequery'] = $lastbasequery;
            header("location: ".$referer); //if Ok go to 'login' form
        }        
        else {
            $lastbasequery .= "Registration unsuccessful\n Try again.";
            //keeps status of last db operation
            $_SESSION['lastbasequery'] = $lastbasequery;
            //if not Ok stays here 'in dataedit' form
        }                
    }
    else {
        // prepares filename for moving from'temp/' to'images/' 
        if($imageURL != $old_imageURL) $storedimageURL = movingfilename($imageURL);
        //also checks if image was not changed keeps the same file
        else $storedimageURL = $imageURL;
        $sql = "UPDATE users SET "
            ."first_name=\"".$first_name."\", "
            ."last_name=\"".$last_name."\", " 
            ."role_id=".$role_id.", "
            ."email=\"".$email."\", "
            ."image=\"".$storedimageURL."\", "
            ."password=\"".$password."\" "
            ."WHERE id=".$id.";";
            //echo $sql;
        $Ok = mysqli_query($connect, $sql);
        mysqli_close($connect);
        if($Ok){ 
            $lastbasequery = "Data update successful.";
            if($imageURL != $old_imageURL){ 
                if(rename($imageURL,$storedimageURL)) {//moving image file from 'temp/' to 'images/'
                    if($old_imageURL != "") unlink($old_imageURL); // clears disk space by removal old image
                    $lastbasequery .= " Image file updated.";
                }    
                else $lastbasequery .= " Image file not updated.";
            }
        }        
        else {
            $lastbasequery = "Update unsuccessful.";
        }    
        //$lastbasequery.="image=". $image."  \n  oldimage=".$oldimage;
        $_SESSION['lastbasequery'] = $lastbasequery;
        // update session info if current user updates own information
        if(isset($_SESSION['auth']) && isset($_SESSION['myid']) && ($_SESSION['myid'] == $id)){
            $_SESSION['myfirst_name'] = $first_name;
            $_SESSION['mylast_name'] = $last_name;
            $_SESSION['myrole'] = $role_id;
        }
        //returns on previous(referer) form and keeps status of last db operation
        
        header("location: ".$referer);
    }
}    
else {
    $error = $error." Please, enter data again.";
}    
function movingfilename($FileName){
    $target_dir = "public/images/";
    $BaseFileName = pathinfo($FileName,PATHINFO_BASENAME);
    return ($target_dir.$BaseFileName);
}
?>