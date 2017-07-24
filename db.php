 <?php
	$con = new mysqli("localhost","klab","Klab@123456789","coffebar");

		if($con->connect_errno){
		die('Sorry we have some problem with the Database!');
	}  
?>
