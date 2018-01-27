<?php

session_start();

include('../class.misc.php');

$file = new mainc();


if(isset($_POST['user_create'])){

  
   echo "<script>console.log( 'Debug Objects: " . print_r($_POST) . "' );</script>";


  if($file->usercreate($_POST)){
  

 
   }
 }


 if(isset($_POST['user_login'])){

  //print_r($_POST);
  

  if(isset($_SESSION['uid']) && isset($_SESSION['uname']) && isset($_SESSION['uemail'])){
     header('location:../index.php');
     exit();
  }

   $user_info = $file->userlogin($_POST);
  if(!$user_info){
    $_SESSION['msg']='Wrong username or password!';
  }
   else{
     //set the session variable
      $_SESSION['user_info'] = $user_info;
      $_SESSION['uid'] = $user_info[0];
      $_SESSION['uname'] = $user_info[1];
      $_SESSION['uemail'] = $user_info[2];
      header('location:dashboard.php');
      exit();
    }
  
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock36</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="../js/jquery.js"></script>
  </head>

<body>
     
<div class="navbar navbar-default  navbar-fixed-top" role="navigation">
 <div class="container">
   <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
     
    <span class="sr-only"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    
    </button>

    <a class="navbar-brand" href="../index.php">Stock36</a>
   </div>
   <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li ><a href="#login" data-toggle="modal" data-target="#loginModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
  </div>
  
 </div>
</div>


<div class="container" style="margin-top: 70px;">
    <div class="jumbotron centered-text">
      <h1 align="center">Register yourself</h1>
    </div>
</div>


<div class="row">
   
   <div class="col-md-1" >
      
   </div>
  
  
   <div class="col-md-9" style="background-color:#d7d9dd; border-radius: 5px; height: 500px;margin-left: 65px;">

    <br>
     <?php   if(isset($_SESSION['msg'])){
             echo '<font size="5"><center>'.$_SESSION['msg'].'</center></font>';
             $_SESSION['msg']='';
        } 
      ?>
     
    <br>
    <div id="form">
     <div class="form-reg brdr">
      <form class="form-horizontal" name="Form" method="post" action="#" id="reg-form">
           
              

            <div class="form-group">
             <label class="control-label col-sm-4" for="pass">Name:</label>
             <div class="col-sm-7"> 
               <input type="text" name="user_fname" class="form-control textInput" id="fname" placeholder="Enter Full name">
             </div>
            </div>

           <!--  <div class="form-group">
             <label class="control-label col-sm-4" for="pass"><font color="#ffcc00">*</font>Address:</label>
             <div class="col-sm-7"> 
               <input type="text" name="user_addr" class="form-control textInput" id="addr" placeholder="Enter Address">
             </div>
            </div>

            <div class="form-group">
             <label class="control-label col-sm-4" for="pass"><font color="#ffcc00">*</font>Phone:</label>
             <div class="col-sm-7"> 
               <input type="number" name="user_phone" class="form-control textInput" id="phone" placeholder="Enter Phone No">
             </div>
            </div>
             -->
            <div class="form-group">
             <label class="control-label col-sm-4" for="pass">Email:</label>
             <div class="col-sm-7"> 
               <input type="email" name="user_email" class="form-control textInput" id="email" placeholder="Enter email">
             </div>
            </div>


            <div class="form-group">
             <label class="control-label col-sm-4" for="pass">Password:</label>
             <div class="col-sm-7"> 
               <input type="password" name="user_pass" class="form-control textInput" id="pass" placeholder="Enter Password">
             </div>
            </div>

            <div class="form-group">
             <label class="control-label col-sm-4" for="pass">Investor Type:</label>
             <div class="col-sm-7"> 
               <select name="user_invtype" style="color:black; height:32px; width:300px;">
               <option value="Individual Investor">Individual Investor</option>
               <option value="Institutional Investor">Institutional Investor</option>
               
               </select>
              </div>
            </div>

            <div class="form-group">
             <label class="control-label col-sm-4" for="pass">Trading Type:</label>
             <div class="col-sm-7"> 
               <select name="user_trdtype" style="color:black; height:32px; width:300px;">
               <option value="Day Trader">Day Trader</option>
               <option value="Short-Term Trader">Short-Term trader</option>
               <option value="Long-Term Trader">Long-Term trader</option>
               
               </select>
              </div>
            </div>

            <div class="form-group">
             <label class="control-label col-sm-4" for="pass">Trading Type:</label>
             <div class="col-sm-7"> 
               <select name="user_captype" style="color:black; height:32px; width:300px;">
               <option value="Large Cap">Large Cap</option>
               <option value="Mid Cap">Mid Cap</option>
               <option value="Small cap">Small cap</option>
               
               </select>
              </div>
            </div>


            <div class="form-group"> 
              <label class="control-label col-sm-4" for="pass"></label>
              <div class="col-sm-7"> 
               <input type="submit" name="user_create" value="Register" class="btn btn-primary btn"/>
              
              </div>

            </div> 





    </div>
      
   </div>
  
   
    
</div>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
   
       
        
  </body>
</html>


<div id="loginModal" class="modal fade" role="dialog">  
      <div class="modal-dialog">  
   <!-- Modal content-->  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Login</h4>  
                </div>  
                <div class="modal-body">  
                     <label>EmailID</label>  
                     <input type="email" name="uemail" id="uemail" class="form-control" />  
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="passwd" id="passwd" class="form-control" />  
                     <br />  
                      <br>
                     <input type="submit" name="user_login" value="Login" class="btn btn-primary btn"/>
              
                </div>  
           </div>  
      </div>  


 <script>


$(document).ready(function(){



});

</script>
