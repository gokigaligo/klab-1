
<?php
	include '../db.php';
	if (isset($_POST['status'])) {
		$sms = '';
		$status = $_POST['status'];
		$id = $_POST['id'];
		if ($status == 'Receive') {
			$sms = 'Your Order was allowed. wait few time';
			$update = $con -> query("UPDATE orders SET status = 'Receive', bg = 'primary' WHERE conf_id = '$id'");
		}
		elseif ($status == 'Reject') {
			$sms = 'Your Order was rejected.';
			$update = $con -> query("UPDATE orders SET status = '$status', bg = 'danger' WHERE conf_id = '$id'");
		}
		elseif ($status == 'delivered') {
			$sms = 'Your Order is coming.';
			$update = $con -> query("UPDATE orders SET status = '$status', bg = 'success' WHERE conf_id = '$id'");
		}
		$update = $con -> query("UPDATE orders SET status = '$status' WHERE conf_id = '$id'");
		$select = $con -> query("SELECT * FROM customers WHERE conf_id = '$id' LIMIT 1");
		$Cusinfo = mysqli_fetch_array($select);
		$recipients = '+25'.$Cusinfo['customer_phone'].'';
		// Be sure to include the file you've just downloaded
		require_once('sms/AfricasTalkingGateway.php');
		// Specify your login credentials
		$username   = "aizokini";
		$apikey     = "5129893a224d6c8afbc695b65b7d5da9d13eb3182016f373085cc394d34f329a";
		// Specify the numbers that you want to send to in a comma-separated list
		// Please ensure you include the country code (+250 for Rwanda in this case)
		// And of course we want our recipients to know what we really do
		$message    = $sms;
		// Create a new instance of our awesome gateway class
		//$from = "UPLUS";

		$gateway    = new AfricasTalkingGateway($username, $apikey);
		// Any gateway error will be captured by our custom Exception class below, 
		// so wrap the call in a try-catch block
		try 
		{ 
		  // Thats it, hit send and we'll take care of the rest. 
		  $results = $gateway->sendMessage($recipients, $message);
		            
		  // foreach($results as $result) {
		  //   //status is either "Success" or "error message"
		  //   echo " Number: " .$result->number;
		  //   echo " Status: " .$result->status;
		  //   echo " MessageId: " .$result->messageId;
		  //   echo " Cost: "   .$result->cost."\n";
		  // }
		}
		catch ( AfricasTalkingGatewayException $e )
		{
		  //echo "Encountered an error while sending: ".$e->getMessage();
		}
		header("location: orderview");
	}
?>