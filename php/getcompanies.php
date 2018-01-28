<?php

if (session_status() == PHP_SESSION_NONE){
  session_start();
}

include('../database.php');




$dbcon = new dbase();
     $output='';

      $sql = "SELECT * FROM companies WHERE name LIKE '%".$_POST["search"]."%' OR symbol LIKE '%".$_POST["search"]."%'";

      $query = mysqli_query($dbcon->connect(),$sql); 
      if($query->num_rows > 0){
       	 $output.='<h3 align="center">Found companies:</h3>'; 
        $output.='<div class="table-responsive">
		            <table class="table table bordered table-striped table">
		              <tr>
		                <th>Symbol</th>
		                <th>Name</th>
		                <th>Sector</th>
		                <th>Industry</th>
		                ';
		               if(isset($_SESSION['uname']))  
		                { $output.='<th>Fetch</th>
		                  </tr>';
		                 }
                       else
		                $output.='</tr>';

         while($rows=mysqli_fetch_array($query)) 
          { 
              $output.='<tr>
                            <td>'.$rows['symbol'].'</td>
                            <td>'.$rows['name'].'</td>
                            <td>'.$rows['sector'].'</td>
                            <td>'.$rows['industry'].'</td>
                            ';
                          
                          if(isset($_SESSION['uname']))  
                          {  		               
                           $output.='<td><a href="php/fetch.php?search='.$rows["symbol"].'" class="btn btn-success"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                              </td>
                            </tr>';
                           }
                           else
		                $output.='</tr>';

                  }
                 

          
           
           echo $output;  
      }
      else  
      {  
           echo 'Sorry!! Can\'t find the comapnay';  
      }  


?>

