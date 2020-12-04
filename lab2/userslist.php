<?php
    session_start();
    $logo_image = "logo00.jpg";
    $edituserdata_form = "edituserdata.php"; // 'edituserdata' form file
    $adduserdata_form = "edituserdata.php";  // w/o POST[id'] acts as 'register' form 
    $signin_script = "checkusercredentials.php"; //'login' script file
    $signout_form = "logout.php";             // 'logout' form file   
    $deleteuserdata_form = "deleteuserdata.php"; // 'deleteuserdats' form file   
    $lastbasequery = "";    //keeps information on db operationd status
    $auth = false;          //if user authrntificated
    $admin = false;         //if authentificated  user has admin role
    
    $myfirst_name = "";     //keeps 'first_name' of authentificated  user
    $mylast_name = "";      //keeps 'first_name' of authentificated  user
    $myrole_id = 0;         //keeps 'role_id' of authentificated  user
    $myid = 0;              //keeps 'id' of authentificated  user
    
    require_once 'connection.php';
    $sql = "SELECT users.id, users.first_name, users.last_name, users.email, users.role_id, roles.title, users.image ".
           "FROM users LEFT JOIN roles ".
           "ON users.role_id=roles.id;";
    $result = mysqli_query($connect, $sql);
    mysqli_close($connect);
    if (isset($_SESSION['image'])) unset($_SESSION['image']); //clears image uploading operation if was done 
    if(isset($_SESSION['lastbasequery']))$lastbasequery = $_SESSION['lastbasequery'];
    if(isset($_SESSION['auth'])&&(isset($_SESSION['myid']))) {
        $auth = $_SESSION['auth'];
        $myid = $_SESSION['myid'];
        if(isset($_SESSION['myfirst_name']))$myfirst_name = $_SESSION['myfirst_name'];
        if(isset($_SESSION['mylast_name']))$mylast_name = $_SESSION['mylast_name'];
        if(isset($_SESSION['admin'])) $admin = $_SESSION['admin'];
    }
    else
        $_SESSION['auth'] = false;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--<link rel="stylesheet" href="layout.css">-->
        <title>Selected User</title>
         <meta charset="UTF-8">
         <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
         <meta http-equiv="X-UA-Compatible" content="ie=edge">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
         <link rel="import" href="signinuser.html">
        <style>
           table {
                width: 100%; 
                background: white; 
                color: black; 
                border-spacing: 0px; 
             }
            th {
                background: darkgray; 
                color: white;
                padding: 5px; 
                text-align: center;
                vertical-align: middle;
                padding-bottom: 10px;
                padding-top: 10px;
                border: solid 0.5px #000;
            }
            td {
                /*background: lightgrey;*/ 
                padding: 5px; 
                text-align: center; 
                vertical-align:middle; 
                padding-bottom: 10px;
                padding-top: 10px;
                color: black;
                border: solid 0.5px #000;
            }
             * {
                margin: 0;
                padding: 0;
            }
/*            tbody tr:nth-child(odd) {
                background-color: lightgray; //фон нечетных строк 
            }
            tbody tr:nth-child (even) {
                background-color:lightsteelblue;// фон четных строк 
            }--> */
        </style>
    </head>
  <body style="padding-top: 0;">
  <!-- Modal Structure -->
    <div id="Signin_form" class="modal">
        <div class="modal-content">
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
        <!--<iframe seamless src="auth.php" height="700" width="100%">           
        </iframe>-->
      <!--      <script>
                var link = document.querySelector('link[rel=import]');
                var content = link.import.querySelector('.signin_form');
                document.body.appendChild(content.cloneNode(true));
            </script>-->       
        </div>
   <!-- <div class="modal-footer">
        <a class="waves-effect waves-light btn" id="createPost">Создать пост.</a>
        </div>-->
  </div> 
    
    <div class="container center" >    
          <header class="header" style="padding: 0; margin: 0; background: gray; color:white"><h4>User list handling...</h4></header>    
    </div>        
    <div class="container row"> 
        <!-- makes 'form' and 'submit' to use POST method-->    
        <section class="left">
            <img src="<?php echo $logo_image?>" height="75" style="margin: 0; padding: 0">
        </section>
        <?php
            if($auth){
                echo"<form class=\"right\" style=\"margin: 0; padding: 0\";>";
                echo"<a href=\"".$signout_form."\"><h5>Sing out</h5></a>";
                echo"</form>";
       
                echo"<section class=\"right\">";
                echo"<h5> &ensp;|&ensp; </h5>";
                echo"</section>";
       
                echo"<form action=\"".$edituserdata_form."\" method=\"post\" class=\"right\" style=\"margin: 0; padding: 0;\";>";
                echo"<a href=\"#\" onclick=\"parentNode.submit();\"><h5>".$myfirst_name." ".$mylast_name."</h5></a>";
                echo"<input type=\"hidden\" name=\"id\" value=\"".$myid."\">";
                echo"</form>";
            }
            else{
                //echo"<form class=\"right\"> <a href=\"".$signin_form."\"><h5>Sing In</h5></a></form>";
                echo"<form class=\"right\">";
                echo "<a href=\"#\"class=\"modal-trigger\" data-target=\"Signin_form\"><h5>Sing In</h5></a>";        
                echo"</form>"; 
                echo"<section class=\"right\">";
                echo"<h5> &ensp;|&ensp; </h5>";
                echo"</section>";
                
                echo"<form action=\"".$adduserdata_form."\" method=\"post\" class=\"right\">";
                //w/o POST['id'] 'edituserdata_form' acts as 'registration' form
                echo"<a href=\"#\" onclick=\"parentNode.submit();\"><h5>Sing up</h5></a>";
                echo"</form>";
                // <!--'href' simulates 'subnit' input behavior using JS function-->
            }
        ?>
    </div>  
    <div class="container" > 
        <section class="center">
        <?php echo ($lastbasequery != "") ? "Last operation status: ".$lastbasequery : " "; ?>
        </section>    
        
        <form>    
        <?php
            if ($result != null){ // output data of each row
                echo "<table class=\"striped\"> <tr>".
                    "<th><form>"."Edit"."</form></th> <th>"."First name"."</th><th>"."Last name"."</th><th>"."Role"."</th>".
                    "<th>"."Email"."</th>";
                echo"<th>"."Image"."</th>";
                if($admin && $auth) echo"<th><form>Remove</form></th>";  //shows 'Remove' column for 'admin' role
                echo"</tr>";
                echo"<tbody>";
                //echo"<form></form>";
                $i = 0;  
                while ($row = mysqli_fetch_array($result)){
                    //<!-- makes 'form' and 'submit' to use POST method--> 
                    // <!--'href' simulates 'subnit' input behavior using JS function-->
                    if($row['id'] == $myid){ // not show myself in the list
                        $myfirst_name = $row['first_name'];
                        $mylast_name = $row['last_name'];
                        $myrole = $row['role_id'];
                        continue;
                    }
                    echo"<tr><td>";
                    echo"<form action=\"".$edituserdata_form."\" method=\"post\">";
                    echo"<a href=\"#\" onclick=\"parentNode.submit();\"><b>".++$i."</b></a>";
                    echo"<input type=\"hidden\" name=\"id\" value=\"".$row['id']."\">";
                    echo"</form>"; 
                    echo"</td>";                      
                    echo "<td>".$row['first_name']."</td><td>".$row['last_name'].
                            "</td><td>".$row['title']."</td><td>".$row['email']."</td>";
                    echo "<td> <img src=\"".$row['image']."\" width=\"50\"></td>";
                    //<!-- makes 'form' and 'submit' to use POST method--> 
                    if($admin && $auth) { //shows 'Remove' column for 'admin' role
                        $cell = "<form action=\"".$deleteuserdata_form."\" method=\"post\">".
                         "<input type=\"hidden\" name=\"id\" value=\"".$row['id']."\">".
                         "<input type=\"image\" name=\"id\" alt=\"\" src=\"delete.png\" width=25 heigh=25>".
                         "</form>"; 
                        echo"<td>$cell</td>";
                    }   
                    echo"</tr>";
                }
                echo"</tbody></table>";
            }
        ?> 
        </form>
    </div>
    <div class="container">
        <section class="right">
            <br>
        <!--<a class="waves-effect waves-light btn-small" href="edituserdata.php/?btn=Register&id=0">Add user</a>-->
        <!-- makes 'form' and 'submit' to use POST method--> 
        <!--<form action="edituserdata.php" method="post">
            <input class="waves-effect waves-light btn-small" type="submit" value="Add user" 
            formaction="edituserdata.php" formmethod="post">
        </form>-->
            <?php
                if($admin && $auth) echo"<a class=\"btn\" href=\"".$adduserdata_form."\">Add user</a>";
                //w/p POST['id'] 'edituserdata_form' acts as 'registration' form
            ?>    
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script> 
        document.addEventListener('DOMContentLoaded', () => {
            modal = M.Modal.init(document.querySelector('.modal'))
        })
    </script>
</body>
</html>
