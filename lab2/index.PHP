<?php
require_once 'userslistscript.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--<link rel="stylesheet" href="layout.css">-->
        <title>Userlist</title>
         <meta charset="UTF-8">
         <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
         <meta http-equiv="X-UA-Compatible" content="ie=edge">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <style>
           table {
                width: 100%; 
                color: black; 
                border: none;
                /*border-spacing: inherit;*/
                border-collapse: collapse;
               /* border: 0.1px solid #d6d6d6;
                outline: 0.1px solid #d6d6d6;*/
                }
            th {
                background-color: darkgray; 
                color: white;
                padding: 5px; 
                text-align: center;
                vertical-align: middle;
                border: solid 0.1px #000;
                border-top: none;
            }
            td {
                padding: 2px; 
                text-align: center; 
                vertical-align:middle; 
                color: black;
                border: solid 0.1px #000;
                border-top: thin dashed;
                border-bottom: thin dashed;
            }
            * {
                margin:0;
                padding:0;
            }
            .modal { 
                width: 40% !important ; 
              /*  height: 75% !important ; */
            }
            th {
                position: -webkit-sticky;
                position: sticky;
                top: 0;
                z-index: 1;
            }
            div[role="scrolledtable"] {
                overflow: auto;
                max-height: 400px;
                border: 0.1px solid #000;
            }
   
        </style>
    </head>
  <body style="padding-top: 0;">
  <!-- Modal window for sign in operation-->
  <div id="signin" name="signin" class="modal">
      <div class="left"> 
            <img src="<?php echo $signinSVG?>" width="50" heigh="50">
      </div>   
      <a href="#" class="modal-close right">✖&ensp;</a>
      <form class="right" action="<?php echo$signin_script?>" name="signin_form" method="post">
            <div class="modal-content">
                <!--<p> <h4>Sign in</h4> </p>-->
                <input placeholder="Enter email" 
                   value="" type="text" name="email" >
                <label for="email" class="active">Email</label>
                <input placeholder="Enter password" 
                   value="" type="password" name="password">
                <label for="password" class="active">Password</label>
            </div>
            <div class="modal-footer">                    
                <input type="submit" name="submit" value="Sign in" class="btn">                
                <a href="#!" class="modal-close waves-effect waves-green btn">Cancel</a>
             </div>
        </form>
    </div>
  <!-- Modal window for remove  operation-->
    <div  id="remove" name="remove" class="modal">
        <div class="left"> 
            <img src="<?php echo $removeuserSVG?>" width="50" heigh="50">
            &ensp;
        </div>    
        <form class="rigth" id="remove_form" name="remove_form" action="<?php echo $deleteuserscript?>" method="post">    
            <a href="#" class="modal-close right">✖&ensp;</a>
            <div class="modal-content">
                You are going to remove information on user:<br>
                <b><Span id="user_name"><Span></b><br>
            </div>
            <div class="modal-footer">    
                <b>Please, confirm&ensp;&ensp;</b>
                <input type="hidden" id="id" name="id">
                <input type="submit" name="submit" value="Yes" class="btn">
                <a href="#!" class="modal-close waves-effect waves-green btn">No</a>
            </div>      
        </form>   
    </div>
    <div class="container center" >    
          <header class="header" style="padding: 0; margin: 0; background: gray; color:white"><h4>User list handling...</h4></header>    
    </div>        
    <div class="container row" width="70%"> 
        <!-- makes 'form' and 'submit' to use POST method-->    
        <section class="left">
            <img src="<?php echo $logo_image?>" height="75" style="margin: 0; padding: 0">
        </section>
        <?php
            if($auth){
                echo"<form class=\"right\" style=\"margin: 0; padding: 0\";>";
                echo"<a href=\"".$signout_form."\"><h5>Sign out</h5></a>";
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
                echo"<form class=\"right\">";
                echo "<a href=\"#\"class=\"modal-trigger\" data-target=\"signin\"><h5>Sing In</h5></a>";        
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
            <p style="color:#dd2c00">
                <?php echo ($lastbasequery != "") ? "Last operation status: ".$lastbasequery : " "; ?>
            </p>    
        </section>     
    </div>    
    <div class="container" role="scrolledtable">     
        <table id="userstable"  class="striped" >
            <thead>
        <?php
            if ($result != null){ // output data of each row
                echo"<tr>";
                echo"<th width=\"5%\"><form><img src=\"".$edituserSVG."\" alt=\"edit user info\">#</form></th>";
                echo"<th width=\"20%\"><img src=\"".$first_nameSVG."\" alt=\"user first name\">First name</th>";
                echo"<th width=\"20%\"><img src=\"".$last_nameSVG."\" alt=\"user last name\">Last name</th>";
                echo"<th width=\"20%\"><img src=\"".$emailSVG."\" alt=\"user email\">Email</th>";
                echo"<th width=\"10%\"><img src=\"".$titleSVG."\" alt=\"user title\">Title</th>";
                echo"<th width=\"10%\"><img src=\"".$imageSVG."\" alt=\"user image\">Image</th>";
                if($admin && $auth) echo"<th width=\"5%\"><form><img src=\"".$removeSVG."\" alt=\"delete user\"></form></th>";  //shows 'Remove' column for 'admin' role
                echo"</tr>";
            }    
         ?>  
            </thead>
            <tbody> 
        <?php        
                $i = 0;  
                while ($row = mysqli_fetch_array($result)){
                    if($row['id'] == $myid){ // not show myself in the list
                        $myfirst_name = $row['first_name'];
                        $mylast_name = $row['last_name'];
                        $myrole = $row['role_id'];
                        continue;
                    }
                    echo"<tr>";
                    //<!-- makes 'form' and 'submit' to use POST method--> 
                    // <!--'href' simulates 'submit' input behavior using JS function-->
                    echo"<td>";
                    echo"<form action=\"".$edituserdata_form."\" method=\"post\">";
                    echo"<a href=\"#\" onclick=\"parentNode.submit();\"><b>".++$i."</b></a>";
                    echo"<input type=\"hidden\" name=\"id\" value=\"".$row['id']."\">";
                    echo"</form>"; 
                    echo"</td>";
                    echo"<td>".$row['first_name']."</td>";
                    echo"<td>".$row['last_name']."</td>";
                    echo"<td>".$row['email']."</td>";
                    echo"<td>".$row['title']."</td>";
                    if($row['image'] != ""){
                        echo "<td> <img src=\"".$row['image']."\" width=\"70\"></td>";
                    }    
                    else {
                        echo "<td> <img src=\"".$no_imageURL."\" width=\"70\"></td>";
                    }    
                    if($admin && $auth) { //shows 'Remove' column for 'admin' role
                        echo"<td>";  
                        echo"<input type=\"image\" name=\"remove_image\" id=\"".$row['id']."\" "
                                . "value=\"".$row['first_name']." ".$row['last_name']."\" "
                                . "class=\"modal-trigger\" data-target=\"remove\" "
                                . "src=\"".$removeuserSVG."\" width=25 heigh=25>";                        
                        echo"</td>";
                    }   
                    echo"</tr>";
                }
        ?> 
            </tbody>      
        </table>
    </div> 
    <div class="container">
        <section class="right">
            <br>
            <?php
                if($admin && $auth) echo"<a class=\"btn\" href=\"".$adduserdata_form."\">Add user</a>";
                //w/o POST['id'] 'edituserdata_form' acts as 'registration' form
            ?>    
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script> 
        document.addEventListener('DOMContentLoaded', () => {
            mw = document.querySelectorAll('.modal');
            mw.forEach(init_modal);
            function init_modal(item) {
                modal = M.Modal.init(item);
            }
        })
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script> //src="deleteuserscript.js" 
        let imagebuttons = document.getElementsByName("remove_image"); //
        for(let i = 0; i < imagebuttons.length; i++){   
    //        console.log('id', imagebuttons[i].id,'  ',imagebuttons[i].value);
            imagebuttons[i].onclick = function (){
                 let remove_form = document.forms['remove_form'];
                 //console.log('form', remove_form);
                 let id = remove_form.elements['id'];
                 id.value = this.id;
                 let span = document.getElementById('user_name');
                 span.textContent = this.value;
            }
        } 
    </script>
</body>
</html>