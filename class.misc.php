<?php
/*
Comments
=========
Biosangam 2018, MNNIT ALLAHABAD
BACKEND CODE BY MANJIT RAJ
*/
if (session_status() == PHP_SESSION_NONE){
  session_start();
}


include('database.php');
class mainc{

	public $myconx;
    
    public function __construct(){
    	$dbcon = new dbase();
    	$this->myconx = $dbcon->connect();
    }
    
	public function usercreate($data){ //print_r($data);
		
            
            if($this->email_if_exist($data['user_email']) == 'exist'){
              $_SESSION['msg']='This email is already registered';
              
            }

            else{
	      
               $data['user_pass'] = $this->hash_password($data['user_pass']);
				
               $sql = "INSERT INTO users (name,email,passwd,invtype,trdtype,captype) 
			                VALUES 
		           ('".$data['user_fname']."','".$data['user_email']."','".$data['user_pass']."','".$data['user_invtype']."','".$data['user_trdtype']."','".$data['user_captype']."')";
		             //echo $sql; die();
		           
		           $query = mysqli_query($this->myconx,$sql); 
		           if($query){
		           //send registration email $data['acc_temp_token'],$data['user_email']
               $_SESSION['msg']='You are successfully registered. Go to login';
		           return true;
		        }
            else{
		          $_SESSION['msg']='Unknown error occurred, contact Administrator';
		        }

	      }

   	}

	public function userlogin($data){
	   //lets clean the user data
       //$data = $this->sanitize_data($data);
       //$_SESSION['log_msg'] = '';
       //hash the password
      

		$pass = $this->hash_password($data['passwd']);
    $pass = substr($pass, 0,20);

       $sql = "select * from users where email = '".$data['uemail']."' and passwd = '".$pass."' ";
        
       $query = mysqli_query($this->myconx,$sql); 
       if($query->num_rows > 0){
       	  $row = mysqli_fetch_row($query);
          return $row;
         }
      else
        return false;
	}

  /*

	public function sanitize_data($info){
		if(!$info)
			return;
        foreach($info as $key => $formData){
          //escaping special characters,symbol if any present and setting the 
          //respective variables for validation
          $info[$key] = htmlspecialchars(mysqli_real_escape_string($this->myconx,$formData));
        }
        return $info;
	}

	
   public function validate_data($data,$check2){
    //check for presence. we will check for all the fields, except for checkbox field. Here we are getting 
    //all the keys using array function but separately we can make it as array
    $check = array_keys($data);
    $errors = '';
    foreach($check as $value){
       if(!$this->has_presence($data[$value])){
         $errors[$value] = $value." can't be blank";
       }
    }

    foreach($check2 as $key => $val){
      if(!empty($data[$key]) && $data[$key] != ''){
        if(!$this->has_min_length($data[$key],$val)){
          if($key=='user_fname')
          $errors[$key] ='Name should be of minimum '.$val.' characters';
          else if($key=='user_pass')
          $errors[$key] ='Password should be of minimum '.$val.' characters';
          else
          $errors[$key] ='Mobile number should be of minimum '.$val.' digits';
        }
      }
    }

    //for password
	if(!empty($data['user_pass']) && empty($errors['user_pass'])){
	   if($data['user_pass'] !== $data['user_cpass']){
	  	 $errors['password'] = "Password do not match";
	   }elseif($this->check_pass($data['user_pass']) == false){
	   	$errors['user_pass'] = "Password should contain at least one lower case,upper case,number and special symbol";
	   }
	 }

	 //matching email pattern
	 if(empty($errors['user_email']) && isset($data['user_email'])){
	 	if(filter_var($data['user_email'],FILTER_VALIDATE_EMAIL) === false){
	 		$errors['user_email'] = 'Email is not valid';
	 	}
	 }

	 //matching mobile number
	 if(empty($errors['user_mobile']) && isset($data['user_mobile'])){
	 	if($this->validate_mobile($data['user_mobile']) == false){
	 		$errors['user_mobile'] = 'Invalid mobile number';
	 	}
	 }

    //ans assign an extra key for error array for any error
    //print_r($errors);die();  
    return $errors; 

   }

   public function has_presence($val){
      if(!empty($val) && $val!=''){
        return true;
      }
      return false;
   }

   public function has_min_length($val,$length){
      if(strlen($val) >= $length){
        return true;
      }
      return false;
   }

   public function validate_mobile($val){
   	//for all preg_match('/^[0-9]{10}+$/',$val) for all 10 digit numbers
      return true;
   }

   public function validate_email($val){
 	  return preg_match('/^[A-z0-9_.\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $val);
   }

   public function check_pass($val){
      return preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,40}$/',$val);
   }*/

   public function email_if_exist($email){
   	if(!$email)
   		return;
   	$sql = "select email from users where email = '".$email."' ";
   	$query = mysqli_query($this->myconx,$sql);
   	if($query->num_rows > 0){
   		return 'exist';
   	}
   	return;
   }

   public function hash_password($pass){
   	$salt = "sd35#dfgAS{2aQOFf4]!#36kjdh+-khl*&".$pass."9&FHhf@#hk^FM^%$897fhjj}";
    $pass = hash('sha512',$salt);
    return $pass;
   }

   
 
 


}


 ?>
