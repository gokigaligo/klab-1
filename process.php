<?php
include 'dy_cart.php';
?>
<?php
	$floor_name_fill = '';
	$clientofficefill = '';
	if (isset($_GET['clientkind']) && $_GET['clientkind'] == 'non member') { 
		$clientname = $_GET['name'];
		$clientphone = $_GET['phone'];
		$floor_name = $_GET['floor_name'];
		$clientoffice = $_GET['office'];
		$mode = $_GET['mode'];
		$clientkind = $_GET['clientkind'];
		if ($_GET['mode'] == 'delivery') {
			$floor_name_fill = $_GET['floor_name'];
			$clientofficefill = $_GET['office'];
			$totalpay = $cartTotal + 100;
		}
		else{
			$floor_name_fill = '---';
			$clientofficefill = '----';
			$totalpay = $cartTotal;
		}
		include 'db.php';
		$selectlastid = $con -> query("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
		$selected = mysqli_fetch_array($selectlastid);
		$conf_id = $selected['id'] + 1;
		if (isset($_SESSION['cart_array']) && $_SESSION['cart_array']>0) {
			$sqlInsertOrdered = $con ->query("INSERT INTO `orders`(`conf_id`,`product_id_qty`, `get_way`, `ordered_time`, `pay_type`, `status`, `bg`)
			 VALUES ('$conf_id','$product_qty_array', '$mode',now(), 'ondelivery', 'ordered', 'active')");
			$sqlinsertcustomer = $con ->query("INSERT INTO `customers`(`conf_id`, `customer_name`, `customer_phone`, `floor_name`, `office`, `totalpay`, `kind`)
				VALUES('$conf_id', '$clientname', '$clientphone', '$floor_name_fill', '$clientofficefill', '$totalpay', '$clientkind')");
			$sqlinsertnotification = $con ->query("INSERT INTO notification(noti_type,noti_from,noti_time,content)
				VALUES('order', '$clientname', now(), '$clientname need $product_qty_array by $mode')");
			$select = $con -> query("SELECT * FROM users WHERE category != 'super admin'");
			while ($row = mysqli_fetch_array($select)) {
				$recipients = $row['phone'];
				// Be sure to include the file you've just downloaded
				require_once('admin/sms/AfricasTalkingGateway.php');
				// Specify your login credentials
				$username   = "aizokini";
				$apikey     = "5129893a224d6c8afbc695b65b7d5da9d13eb3182016f373085cc394d34f329a";
				// Specify the numbers that you want to send to in a comma-separated list
				// Please ensure you include the country code (+250 for Rwanda in this case)
				// And of course we want our recipients to know what we really do
				$message    = ''.$clientname.' need '.$product_qty_array.' by '.$mode.''.$clientphone.'';
				// Create a new instance of our awesome gateway class
				//$from = "UPLUS";

				$gateway    = new AfricasTalkingGateway($username, $apikey);
				// Any gateway error will be captured by our custom Exception class below, 
				// so wrap the call in a try-catch block
				try 
				{ 
				  // Thats it, hit send and we'll take care of the rest. 
				  $results = $gateway->sendMessage($recipients, $message);
				            
				  foreach($results as $result) {
				    //status is either "Success" or "error message"
				    // echo " Number: " .$result->number;
				    // echo " Status: " .$result->status;
				    // echo " MessageId: " .$result->messageId;
				    // echo " Cost: "   .$result->cost."\n";
				  }
				}
				catch ( AfricasTalkingGatewayException $e )
				{
				  //echo "Encountered an error while sending: ".$e->getMessage();
				}
			}

			echo '<p id="response" class="animate-bottom" style="margin-top: 50px; color: green; font-size: 120%;">
			Thanks you for ordering!!!<br>Wait a moment<br>
			you will pay '.$totalpay.' after you get products</p>';
			unset($_SESSION['cart_array']);
			exit();
		}
		else{
			?>
			<script type="text/javascript">
				window.location.href="all#category";
			</script>
			<?php
		}
	}
	elseif (isset($_GET['memberemail'])) {
		$emailof = $_GET['memberemail'];
		include 'db.php';
		$fetch = $con ->query("SELECT * FROM member WHERE member_email = '$emailof'");
		$countemail = mysqli_num_rows($fetch);
		if ($countemail == 0) {
			echo '
				<p id="response" class="animate-bottom" style="color: red;" id="response" class="animate-bottom">
					your email does not exit in emails of kLab member.<br>
					please check if is really used during registering or pay as non member<br><br>
					<a href="payrol"><button class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> Try Again
					</button></a>
				</p>
			';
		}
		else{
			$clientname = $_GET['name'];
			$clientphone = $_GET['phone'];
			$floor_name = $_GET['floor_name'];
			$clientoffice = $_GET['office'];
			$mode = $_GET['mode'];
			if ($_GET['mode'] == 'delivery') {
				$floor_name_fill = $_GET['floor_name'];
				$clientofficefill = $_GET['office'];
				$totalpay = $cartTotalM + 100;
			}
			else{
				$floor_name_fill = '---';
				$clientofficefill = '----';
				$totalpay = $cartTotalM;
			}
			include 'db.php';
			$selectlastid = $con -> query("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
			$selected = mysqli_fetch_array($selectlastid);
			$conf_id = $selected['id'] + 1;
			if (isset($_SESSION['cart_array']) && $_SESSION['cart_array']>0) {
				$sqlInsertOrdered = $con ->query("INSERT INTO `orders`(`conf_id`,`product_id_qty`, `get_way`, `ordered_time`, `pay_type`, `status`, `bg`)
				 VALUES ('$conf_id','$product_qty_array', '$mode', now(), 'ondelivery', 'ordered', 'active')");
				$sqlinsertcustomer = $con ->query("INSERT INTO `customers`(`conf_id`, `customer_name`, `customer_phone`, `floor_name`, `office`, `totalpay`, `kind`)
					VALUES('$conf_id', '$clientname', '$clientphone', '$floor_name_fill', '$clientofficefill', '$totalpay', 'member')");
				$sqlinsertnotification = $con ->query("INSERT INTO notification(noti_type,noti_from,noti_time,content)
					VALUES('order', '$clientname', now(), '$clientname need $product_qty_array by $mode')");
				$select = $con -> query("SELECT * FROM users WHERE category != 'super admin'");
				while ($row = mysqli_fetch_array($select)) {
					$recipients = $row['phone'];
					// Be sure to include the file you've just downloaded
					require_once('admin/sms/AfricasTalkingGateway.php');
					// Specify your login credentials
					$username   = "aizokini";
					$apikey     = "5129893a224d6c8afbc695b65b7d5da9d13eb3182016f373085cc394d34f329a";
					// Specify the numbers that you want to send to in a comma-separated list
					// Please ensure you include the country code (+250 for Rwanda in this case)
					// And of course we want our recipients to know what we really do
					$message    = ''.$clientname.' need '.$product_qty_array.' by '.$mode.''.$clientphone.'';
					// Create a new instance of our awesome gateway class
					//$from = "UPLUS";

					$gateway    = new AfricasTalkingGateway($username, $apikey);
					// Any gateway error will be captured by our custom Exception class below, 
					// so wrap the call in a try-catch block
					try 
					{ 
					  // Thats it, hit send and we'll take care of the rest. 
					  $results = $gateway->sendMessage($recipients, $message);
					            
					  foreach($results as $result) {
					    //status is either "Success" or "error message"
					    // echo " Number: " .$result->number;
					    // echo " Status: " .$result->status;
					    // echo " MessageId: " .$result->messageId;
					    // echo " Cost: "   .$result->cost."\n";
					  }
					}
					catch ( AfricasTalkingGatewayException $e )
					{
					  //echo "Encountered an error while sending: ".$e->getMessage();
					}
				}
				echo '<p id="response" class="animate-bottom" style="margin-top: 50px; color: green; font-size: 120%;">
					Thanks you for ordering!!!<br>Wait a moment<br>
					you will pay '.$totalpay.' after you get products</p>
				';
				unset($_SESSION['cart_array']);
				exit();
			}
			else{
				?>
				<script type="text/javascript">
					window.location.href="all#category";
				</script>
				<?php
			}

		}
	}
?> 
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		/* Add animation to "page content" */
		.animate-bottom {
		  position: relative;
		  -webkit-animation-name: animatebottom;
		  -webkit-animation-duration: 2s;
		  animation-name: animatebottom;
		  animation-duration: 2s
		}

		@-webkit-keyframes animatebottom {
		  from { bottom:-100px; opacity:0 } 
		  to { bottom:0px; opacity:1 }
		}

		@keyframes animatebottom { 
		  from{ bottom:-100px; opacity:0 } 
		  to{ bottom:0; opacity:1 }
		}

		#response {
		  display: none;
		  text-align: center;
		}
	</style>
</head>
<body>

</body>
</html>