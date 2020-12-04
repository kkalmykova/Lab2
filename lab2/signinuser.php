<?php
    $logo_image = "logo00.jpg";
    $edituserdata_form = "edituserdata.php"; // 'edituserdata' form file
    $adduserdata_form = "edituserdata.php";  // w/o POST[id'] acts as 'register' form 
    $signin_script = "checkusercredentials.php";//'login' script file
    $signout_form = "logout.php";             // 'logout' form file   
    $deleteuserdata_form = "deleteuserdata.php"; // 'deleteuserdats' form file   
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
           width: 400px;
       }
   </style>
</head>
<body style="padding-top: 3rem;">
<div id="signin_form" class="container">
    <p> <h4>Sign in</h4> </p>
    <form action="<?php echo$signin_script?>" method="post">
        <div class="input-field">
            <input placeholder="Enter email" 
                   value="" type="text" name="email" >
            <label for="email" class="active">Email</label>
        </div>
        <div class="input-field">
            <input placeholder="Enter password" 
                   value="" type="password" name="password">
            <label for="password" class="active">Password</label>    
        </div>
        <input type="submit" name="submit" value="Sign in" class="btn">
        <a href="#!" class="modal-close waves-effect waves-green btn">Cancel</a>
   </form>
</div>
</body>
</html>
