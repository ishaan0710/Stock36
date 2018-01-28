<?php

if (session_status() == PHP_SESSION_NONE){
  session_start();
}

include('../database.php');




$dbcon = new dbase();
  
    
    $sql = "INSERT INTO ucomp (uid,comp) 
                      VALUES 
               ('".$_POST['id']."','".$_POST['symbol']."')";
                 //echo $sql; die();
               
               $query = mysqli_query($dbcon->connect(),$sql); 
               if($query){
               
               return '1';
            }

          else
            return '0';

?>

