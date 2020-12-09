<?php
    session_start();
    $error = "";
    //$referer = $_SERVER['HTTP_REFERER'];
    $target_dir = "public/tmp/"; // initially image files kept here 
    // then upon 'update' or 'register' confimation tey will be moved to '/images'   
    $target_file = basename($_FILES["fileToUpload"]["name"]);
    $uploadOk  = true;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Checks if image file is an actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = true;
	} 
        else {
            $error .= "File is not an image.";
            $uploadOk = false;
	}
    }
    $unique_filename = substr(md5(microtime().rand(0, 9999)), 0, 20);
    //generates unique filename
    $target_file = $target_dir.$unique_filename.".".$imageFileType;
    // Checks if file already exists
    if (file_exists($target_file)) {
        $error .= "Sorry, file already exists.";
	$uploadOk = false;
    }
    // Checks file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error .= "Your file is too large.";
	$uploadOk = false;
    }
// Allows certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $error .= "Only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = false;
    }
    // Checks if $uploadOk is set to 0 by an error
    if (!$uploadOk) {
        $error .= "Sorry, your file was not uploaded.";
        $res = '<script type="text/javascript">';
        $res .= ' window.parent.handleResponse("","'.$error.'");';
        $res .= "</script>";
        echo $res;
    // if everything is ok, tries to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "The file ".basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            //echo "The file ". $_FILES["fileToUpload"]["tmp_name"]. " has been uploaded.";
            //echo "<img src=\"".$_FILES['fileToUpload']['tmp_name']."\"height=\"200\" >";        
            //$_SESSION['imageURL'] = $_FILES["fileToUpload"]["tmp_name"];
//            $_SESSION['imageURL'] = $target_file;
            $res = '<script type="text/javascript">';
            //$res .= "var data = new Object;";
           // foreach($data as $key => $value){
           //     $res .= 'data.'.$key.' = "'.$value.'";';
           // }
           // $res .= ' window.parent.handleResponse(data);';
            $res .= ' window.parent.handleResponse("'.$target_file.'","'.$error.'"); ';
            $res .= "</script>";
            echo $res;//image preview by hidden iframe.  Puts Js code that starts  image painting function handleResponse()
	} 
        else {
           $error .= "Sorry, your file was not uploaded due to unknown problem.";
            $res = '<script type="text/javascript">';
            $res .= ' window.parent.handleResponse("","'.$error.'");';
            $res .= "</script>";
            echo $res;
        }
        //header("location: ".$referer);    
    }  
