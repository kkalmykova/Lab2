<?php
require_once 'edituserdatascript.php'
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
        * {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 0;
            margin-left: 0;
            padding-top: 0;
            padding-right: 0;
            padding-left: 0;
            padding-bottom: 0;
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
        <p style="color:#dd2c00"> 
            <span id="error"><?php echo ($error != "")? "<b>".$error."</b>" : " "; ?> </span>
        <p>    
            <!--shows error status of previous data entering iteration-->
        <span id="status"><?php echo ($lastbasequery != "") ? $lastbasequery : " "; ?><br></span> <!--shows status of last db operation-->
    </section>       
    </div>    
    <div class="container row">
        <div class="col s4 left" >           
        <?php 
            echo"<span id=\"imageplaceholder\">";
            if($imageURL != "") 
                echo "<img id=\"image\" src=\"".$imageURL."\" width=\"100%\">";
            else 
                echo "<img id=\"image\" src=\"".$no_imageURL."\" width=\"100%\">";
            echo "</span>";
            if (($admin && $auth) || $mypage) {      
                echo"<form enctype=\"multipart/form-data\" action=\"".$upload_script."\" method=\"post\" "
                . "id = \"uploadimage\" name=\"uploadimage\" target=\"hiddenframe\" "
                . "onchange=\"showloadprogress(); return false;\""
                . " style=\"left: 50%; margin-right: 50%; transform: translate(50%, 50%)\">";
                echo"<div class=\"file-field input-field\">";
                echo"<div class=\"btn\">";
                echo"<span>Upload image</span>";
                echo"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1024000\">";
                echo"<input id=\"fileToUpload\" name=\"fileToUpload\" "
                . "onchange=\"submit();\" type=\"file\" accept=\".jpg,.pgn,.jpeg\">";
                echo"</div>";
              //  echo"<div class=\"file-path-wrapper\">";
              //  echo"<input class=\"file-path validate\" width= \"100\" type=\"text\"";
              //  echo"placeholder = \"Upload image file\" />";
              // echo"</div>";
                echo"</div>";
                echo"</form>";
                echo "<iframe id=\"hiddenframe\" name=\"hiddenframe\" "
                . "style=\"width:0px; height:0px; border:0px\"></iframe>";
            }    
        ?>            
    </div>
    <div class="col s6 right">
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
            <?php 
                //if field disabled shall be POSTed as hidden
                if((!$admin || !$auth) || $mypage){
                    echo"<input value=\"".$role_id."\" type=\"hidden\" name=\"role_id\">";
                }    
            ?>
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
                echo"<input value=\"".$imageURL."\" type=\"hidden\" id=\"imageURL\" name=\"imageURL\">";
                echo"<input value=\"".$referer."\" type=\"hidden\" name=\"referer\">";
                echo"<input value=\"".$old_imageURL."\" type=\"hidden\" name=\"old_imageURL\">";
                echo"</div>";
                echo"<input type=\"submit\" name=\"submit\" value=\"".$btn_title."\" class=\"btn\">";
            }
        ?>
        <a class="btn" href ="<?php echo $referer?>">Cancel</a>
    </form>    
    </div>
    </div>     
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">   
        function showloadprogress(){
            console.log('show load progress');
            $('#status').html("image file is being loaded...");
        }
        function handleResponse(uploaded_file, error) {    
            console.log('handleresponse', uploaded_file, error);
            //$('#uploadimage').show();
            if(error != "") {
                $('#error').html("<b>" + error + "</b>");
                $('#status').html("");
            }
            else {
                $('#imageURL').val(uploaded_file);
                $('#status').html("Upload is Ok");
                $('#error').html("");
                $('#imageplaceholder').html("<img src=\"" + uploaded_file + "\" width=\"100%\">");
            }   
        }
    </script>
</body>
</html>