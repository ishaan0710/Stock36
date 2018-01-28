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

//print_r($_POST);
  

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
      header('location:index.php');
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
     
<div class="navbar navbar-default  navbar-fixed-top" role="navigation" style="background-color:black;">
 <div class="container-fluid" >
   <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
     
    <span class="sr-only"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    
    </button>

    <a class="navbar-brand" href="#" style="color:white;">Stock36</a>
   </div>
  <div class="navbar-collapse collapse" style="color:white;">
      <ul class="nav navbar-nav" style="color:white;">
        <li><a href="#" style="color:white;">Home</a></li>
        <li><a href="#" style="color:white;">Current Trends</a></li>
        <!-- <li><a href="#" style="color:white;">Leader Board</a></li> -->
      </ul> 
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <?php  
                if(isset($_SESSION['uname']))  
                { 
                 
                ?>  
                  
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white;"><span class="glyphicon glyphicon-user" style="color:white;"></span><?php echo '  '.$_SESSION['uname']?><b class="caret"></b></a>      
                  <ul class="dropdown-menu">
                  <li ><a href="#list" data-toggle="modal" data-target="#listModal"><i class="fa fa-list" aria-hidden="true"></i> Your Stocks </a></li>
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

<div class="container-fluid panel-group row" style="margin-top: 70px; margin:auto; padding-top:30px; margin-top:70px;
margin-bottom: 30px; background-color: white;" >
    <div class="col-sm-4" style="padding-left:150px; margin:auto; ">
      <img src="img/logo.png" alt="Logo" style="float:left;border-style:inset;" width="350" height="150">
      </div>
      <div class="col-sm-6" style="border-style:none;">
      <div class="panel panel-default">
      <h2 class="panel-heading">Intro</h2>
      <p class="panel-body">This website is an online platform to get the updates of the stock prices of various market companies, compare them, and predict the future stock trends on the basis of various factors affecting the stock trends in real time.</p>
    </div>
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
   
   
   <div class="col-md-8" style="background-color:white; border-radius: 5px; height: 500px;margin-left: 50px;margin-right: 50px; overflow-y: scroll;">
      <div class="form-group">
        <div class="input-group" style="margin-left: 100px;">
          <br>
          <h4>
           <span class="input-group"><i class="fa fa-search fa-lg" aria-hidden="true"></i>Search</h4></span>
           
           <input type="text" style="width: 400px;height: 40px; padding: 10px;" name="searchtext" id="searchtext" class="form-control" placeholder="Type any company name to search.."/>
        </div>
        
      </div>    
      <br/>
      <div id="result">

    

      </div>
   </div>
  

  <?php
      
            $aContext = array(
          'http' => array(
              'proxy' => 'tcp://172.31.102.14:3128',
              'request_fulluri' => true,
          ),
      );
      $cxContext = stream_context_create($aContext);

            $cdata = file_get_contents("https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=d9f7fdf740eb41698ef6bb2b1ee7ec25",False,$cxContext);

            $content=json_decode($cdata,TRUE);
            //echo '<pre>';
            //print_r($content);

?>
   


   <div class="col-md-3" style="border-radius: 5px; height: 500px; overflow-y: scroll;">
      <ul class="list-group">
          <li class="list-group-item disabled">News</li>

          <?php 
               foreach ($content['articles'] as $key => $value) {
                 
               
                 ?>

          <li class="list-group-item"><b><? echo $value['author'].'</br>'; ?></b>
          <? echo $value['title'].'</br>'; ?>
          </li>

          <? } ?>

          
     </ul>
   </div> 
</div>

<br><br>
<!-- <div class="row">
   <div class="col-md-2" >
     
   </div>
   
   
   <div class="col-md-7" style="background-color:#d7d9dd; border-radius: 5px; height: 350px;margin-left: 50px;margin-right: 50px;">
     
      <div id="result">
      </div>
   </div>
  
   
   <div class="col-md-2">
   
   </div> 
</div> -->




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
       
        
  </body>
</html>
<script>


$(document).ready(function(){


  $('#searchtext').keyup(function(){
      var txt = $(this).val();
      
       
       if(txt.length < 1){
          $('#result').html("");
         return false;
       }

      if(txt!='')
      {
        $.ajax({
             url:"php/getcompanies.php",
             method:"POST",
             data:{search:txt},
             dataType:"text",

             success:function(data){
              $('#result').html(data);
             }
  
        });
      }

      else{
        $('#result').html('');
      }


 });


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
                   <form class="form-horizontal" name="Form" method="post" action="#" id="reg-form"> 
                     <label>EmailID</label>  
                     <input type="email" name="uemail" id="uemail" class="form-control" />  
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="passwd" id="passwd" class="form-control" />  
                     <br />  
                      <br>
                     <input type="submit" name="user_login" value="Login" class="btn btn-primary btn"/>
                   </form>
                </div>  
           </div>  
      </div>  
 </div> 


<div id="listModal" class="modal fade" role="dialog">  
      <div class="modal-dialog">  
   <!-- Modal content-->  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Your Stocks</h4>  
                </div>  
                <div class="modal-body"> 

                   <?php

                     $compd=array();
                     $compd=$file->ucomp($_SESSION['uid']);
                      
                      //print_r($compd);

                   ?>

                    <table class="table table-bordered">  
                <tr>  
                     <th>Company Symbol</th>  
                     <th>Name</th>  
                     <th>Last Sale</th>  
                     <th>Market Cape</th>   
                </tr> 
                  <?php
                     if(is_array($compd)) 
                    foreach ($compd as $key => $value) {
                       # code...
                     
                      ?>
                <tr>
                     <td><?php echo $value[0]; 
                           $col=$file->fetchcomp($value[0]); 
                            
                            for ($i=1;$i<4;$i++) {
                              # 
                            
                       
                            ?></td>

                            <td><?php echo $col[$i];?></td>
                            <? } ?>
                       

                </tr>
                <?php } ?>
                  </table>
                </div>
              </div>  
      </div>  
  </div>
 