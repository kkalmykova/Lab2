<?php
    session_start();
    $referer = $_SERVER['HTTP_REFERER'];
    if(!isset($_POST['id'])){
        header("location: ".$referer);
    }
    else $id = $_POST['id'];
    if(isset($_POST['submit'])){
        if ($_POST['submit'] == "Yes"){
            require_once 'connection.php';
            $sql = "DELETE FROM users WHERE id=".$id.";";
            $Ok = mysqli_query($connect, $sql);
            mysqli_close($connect);
            if($Ok){ 
                $lastbasequery = "Removal successful";   
            }        
            else {
                $lastbasequery = "Removal unsuccessful";
            }    
            $_SESSION['lastbasequery'] = $lastbasequery;
        }        
        header("location: ".$_POST['referer']);
   } 
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
           width: 35%;
       }
   </style>
</head>
<body style="padding-top: 3rem;">
    <div class="container">
        <form action="deleteuserdata.php" method="post">
            <b>You are going to delete user information</b> <br>
            <b>Are you sure?</b> <br>
            <input type="submit" name="submit" value="Yes" class="btn">
            <input type="submit" name="submit" value="No" class="btn">

        <input type="hidden" name="id" value="<?php echo$id ?>">
        <input type="hidden" name="referer" value="<?php echo$referer ?>">
        </form>
    </div>    
</body>
</html>