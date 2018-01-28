 
 <?php

if (session_status() == PHP_SESSION_NONE){
 session_start();
}

include('../class.misc.php');

$file = new mainc();


$symbol=$_GET['search'];


$compdetails=$file->fetchcomp($symbol);

$compd=array();
$compd=$file->ucomp($_SESSION['uid']);

$pred_data=$file->pred_data($symbol);

//print_r($compdetails);

if(isset($_GET['action']) && $_GET['action']=='logout')
{
	
    session_destroy();  
	header("location: ../index.php");
}

//print_r($_SESSION);

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
     

<div class="navbar navbar-default  navbar-fixed-top" role="navigation" style="background-color:black;">
 <div class="container-fluid" >
   <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
     
    <span class="sr-only"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    
    </button>

    <a class="navbar-brand" href="../index.php" style="color:white;">Stock36</a>
   </div>
  <div class="navbar-collapse collapse" style="color:white;">
      <ul class="nav navbar-nav" style="color:white;">
        <li><a href="../index.php" style="color:white;">Home</a></li>
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

<div class="container-fluid" style="margin-top: 70px;">
    <div class="jumbotron" >
      
      <h1 align="center"><?php echo $compdetails[1];?></h1>
      
    </div>
</div>


<div class="row">
   <div class="col-sm-2" style="background-color:#ffffff; height: 350px;">
     <!-- <h3 align="center"><u>Market</u></h3>
      <div id="market">
        <ul>
          <li>bkjbkjbk</li>
          <li>bdfbmjdkn</li>
          <li>sdklvnl</li>
          <li>dskvnjksdb</li>
        </ul>
      </div>
 -->   </div>
   
   
   <div  class=" container col-sm-8" style="background-color:white;  height: 700px;margin-left: auto;margin-right: auto;">
      <center >
        
          <table class="table" style="margin:auto;border-style: none; padding-left:50px;">
            
            <tr style="padding-bottom: 1em; ">
            	<th style="text-align:right;">Symbol : </th><td style="font color=gray;"><font color="gray" ><?php echo $compdetails[0];?></font></td>
            </tr>

            <tr>
            	<th style="text-align:right;">Industry : </th><td><font color="gray"><?php echo $compdetails[6];?></font></td>
            </tr>

            <tr>
            	<th style="text-align:right;">Sector : </th><td><font color="gray"><?php echo $compdetails[7];?></font></td>
            </tr>

            <tr>
            	<th style="text-align:right;">Market Cap : </th><td><font color="gray"><?php echo $compdetails[3];?></font></td>
            </tr>
             
            <tr>
            	<th style="text-align:right;">Last Sale : </th><td><font color="gray"><?php echo $compdetails[2];?></font></td>
            </tr  > 

           
            
           </table>
         
         </center> 


         <div id="predicted" style="margin-left:auto; float: right;">

               <button class="btn btn-success"><h4>Predicted data for today:<? echo $pred_data[1]; ?></h4></button>

         </div>
         <div>

         <input type="hidden" id="id<?php echo $compdetails[0];?>" value="<? echo $_SESSION['uid'];?>">

         <?php
         
           $ch=0;

          if(is_array($compd)) 
          foreach ($compd as $key => $value) {
                     if($value[0]==$compdetails[0]){
                        $ch=1;
                        break;
                      }
                  }

          
          if($ch==0){?>
         <button id="<?php echo $compdetails[0];?>" class="btn btn-lg btn-primary addbtn" ><i class="fa fa-plus" aria-hidden="true"></i>
         Add to your list</button>
        <? }
        else
        {?>
        	<button disabled="true" class="btn btn-lg btn-danger addbtn">
         Already added</button>

         </div>
       <? }

 ?>       
          
           <!-- <h3 align="center">IPO Year:<font color="#42b9f4"><a href="<?php echo $compdetails[8]?>">Link</a></font></h3> -->
<?php
      
            $aContext = array(
			    'http' => array(
			        'proxy' => 'tcp://172.31.102.14:3128',
			        'request_fulluri' => true,
			    ),
			);
			$cxContext = stream_context_create($aContext);

            $cdata = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=$symbol&interval=1min&apikey=LRNOQIEJS3OG4JVB",False,$cxContext);

            $content=json_decode($cdata,TRUE);
            

?>  
  <div  class="alert alert-dark" style="background-color:#e8eaed; color:black; margin-top:30px;">
     <h2 align="center" >Stock details</h2>
   </div>
      <br/>

          
      <div id="result" style="overflow-y: scroll; height: 450px; >
                      <div class="table-responsive">
		             <table class="table table bordered table-striped table">
			              <tr>
			                <th>Date</th>
			                <th>Open</th>
			                <th>High</th>
			                <th>Low</th>
			                <th>Close</th>
			                <th>Volume</th>
			              </tr>
         
                      <?php
                        
                        /*echo "<pre>";
                        print_r($content);*/


                        foreach ($content['Time Series (Daily)'] as $key => $value) {
                         	 ?>

                             <tr><td><?php echo $key.'<br>';?></td>
                                  

                              	
                             <?php

                             foreach ($content['Time Series (Daily)'][$key] as $key1 => $value1) {
                          ?>
                              <td><?php echo $value1;?></td>
                              <?php	
                              } ?>
                          </tr>
                          <?php
                        }
                 ?>


	                      
                      </table>
           </div>   <!--table responsive-->         

         

      </div><!--query result-->
   </div>
  
   
    
</div>

<br><br>
<div class="row">
   <div class="col-sm-2" >
     
   </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
   
       
        
  </body>
</html>   


<script>
 $(document).ready(function(){
 $('.addbtn').click(function(){
   
    var symbol=$(this).attr("id");
     var id=$('#id'+symbol).val();

     console.log(symbol);
     console.log(id);

    $.ajax({
    url:"add.php",
    method:"POST",
    dataType:"text",
    data:{
    symbol:symbol,
    id:id
    },
    success:function(data)
    { 

           var result = $.trim(data);
           
                if(result[0]=='0'){
           alert('Can\'t be added');  
           }
           
           else{     
           alert('Company added');
           $('#'+symbol).attr('disabled',true);
           location.reload();
            
          }
    }
   

   });
  
  
  
  });
});

 </script>


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
 