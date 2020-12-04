<?php
    session_start();
    $target_dir = "public/tmp/"; // initially image files kept here 
    // then upon 'update' or 'register' confimation tey will be moved to '/images'   
    $target_file = basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Checks if image file is an actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = true;
	} 
        else {
            echo "File is not an image.";
            $uploadOk = false;
	}
    }
    $unique_filename = substr(md5(microtime().rand(0, 9999)), 0, 20);
    //generates unique filename
    $target_file = $target_dir.$unique_filename.".".$imageFileType;
    // Checks if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
	$uploadOk = false;
    }
    // Checks file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
	$uploadOk = false;
    }
// Allows certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = false;
    }
    // Checks if $uploadOk is set to 0 by an error
    if (!$uploadOk) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, tries to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "The file ".basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            //echo "The file ". $_FILES["fileToUpload"]["tmp_name"]. " has been uploaded.";
            //echo "<img src=\"".$_FILES['fileToUpload']['tmp_name']."\"height=\"200\" >";        
            //$_SESSION['image'] = $_FILES["fileToUpload"]["tmp_name"];
            $_SESSION['image'] = $target_file;
            if($size = getimagesize($target_file)){ 
                //preview in 'iframe'
                if($size[0]/$size[1] > 250/350) // makes sizes fittable for preview
                    echo "<img src=\"".$target_file."\" width=\"100%\""
                        . "style=\"position: absolute; top: 0; left: 0; bottom: 0; right: 0; "
                        . "margin: auto; margin-bottom: 0;\"> ";
                else
                    echo "<img src=\"".$target_file."\" height=\"100%\""
                        . "style=\"position: absolute; top: 0; left: 0; bottom: 0; right: 0; "
                        . "margin: auto; margin-bottom: 0;\"> ";
                }
            else
                echo "Sorry, this is wrong file.";
	} 
        else {
           echo "Sorry, there was an error uploading your file.";
        }
    }  
