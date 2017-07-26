<?php  
error_reporting(E_ALL); 
ini_set('display_errors', 0);
	$db = new mysqli("localhost", "clement", "clement123" , "uplus");
	
	if($db->connect_errno){
		die('Sorry we have some problem with the Social Database!');
	}
	
	$outCon  = new mysqli("localhost", "clement", "clement123" , "rtgs");
	if($outCon->connect_errno){
		die('Sorry we have some problem with the Money Database!');
	}
?>
