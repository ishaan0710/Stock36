<?php

session_start();

include('class.misc.php');

$file = new mainc();


if(isset($_GET['action']) && $_GET['action']=='logout')
{
  
    session_destroy();  
  header("location:index.php");
}




 if(isset($_POST['user_login'])){

  print_r($_POST);
  

  if(isset($_SESSION['uid']) && isset($_SESSION['uname']) && isset($_SESSION['uemail'])){
     header('location:index.php');
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
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

    <a class="navbar-brand" href="#">Stock36</a>
   </div>
  <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="#">Home</a></li>
        <li><a href="#">Current Trends</a></li>
        <li><a href="#">Leader Board</a></li>
      </ul> 
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <?php  
                if(isset($_SESSION['uname']))  
                { 
                 
                ?>  
                  
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><?php echo '  '.$_SESSION['uname']?><b class="caret"></b></a>      
                  <ul class="dropdown-menu">
                  <li ><a href="#" ><i class="fa fa-list" aria-hidden="true"></i> Your Stocks </a></li>
                  <li ><a href="?action=logout" id="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
                  </ul>
                <?php  
                }  
                else  
                {  
                ?>  
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">User<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                   <li ><a href="#login" data-toggle="modal" data-target="#loginModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                   <li ><a href="php/register.php">Sign Up</a></li>
                  </ul>     
                <?php  
                }  
                ?>  
          
        </li>
      </ul>
  </div>
 </div>
</div>

<div class="container" style="margin-top: 70px;">
    <div class="jumbotron">
      <img src="" alt="Logo" style="float:left;" width="100" height="100">
      <p>Intro about stock36Intro about stock36Intro about stock36Intro about stock36Intro about stock36Intro about stock36Intro about stock36Intro about stock36Intro about stock36</p>
    </div>
</div>


<div class="row">
   <!-- <div class="col-md-2" style="background-color:#d7d9dd; border-radius: 5px; height: 350px;">
     <h3 align="center"><u>Market</u></h3>
      <div id="market">
        <ul>
          <li>bkjbkjbk</li>
          <li>bdfbmjdkn</li>
          <li>sdklvnl</li>
          <li>dskvnjksdb</li>
        </ul>
      </div>
   </div> -->
   
   
   <div class="col-md-9" style="background-color:#d7d9dd; border-radius: 5px; height: 350px;margin-left: 50px;margin-right: 50px;">
      <div class="form-group">
        <div class="input-group">
          <br>
           <span class="input-group"><i class="fa fa-search" aria-hidden="true"></i>Search</span>
           <input type="text" name="searchtext" id="searchtext" class="form-control" placeholder="Type any company name to search.."/>
        </div>
        
      </div>    
      <br/>
      <div id="result">
      </div>
   </div>
  
   
   <div class="col-md-2" style="background-color:#d7d9dd; border-radius: 5px; height: 350px;">
      <h3 align="center"><u>News</u></h3>
       <div id="news">
       </div>
   </div> 
</div>

<br><br>
<div class="row">
   <div class="col-md-2" >
     
   </div>
   
   
   <div class="col-md-7" style="background-color:#d7d9dd; border-radius: 5px; height: 350px;margin-left: 50px;margin-right: 50px;">
     
      <div id="result">
      </div>
   </div>
  
   
   <div class="col-md-2">
   
   </div> 
</div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
       
        
  </body>
</html>
<script>


$(document).ready(function(){

});

</script>


<!--Modal -->

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
 </div> 
