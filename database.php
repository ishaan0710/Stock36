<?php 

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

class dbase{
	public $host = 'localhost';
	public $user = 'root';
	public $pass = '';
	public $db = 'stock36';
    
    public function connect(){
		$mycon = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
		if($mycon){
			return $mycon;
		}else{
			die(trigger_error(mysqli_connect_error()));
		}
	}
}

?>
