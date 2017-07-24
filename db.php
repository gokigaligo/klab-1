 <?php
	$con = new mysqli("localhost","root","phpcoder","coffebar");

		if($con->connect_errno){
		die('Sorry we have some problem with the Database!');
	}  
?>