
<?php
  include '../db.php';
  $select = $con -> query("SELECT * FROM users WHERE category != 'super admin'");
  while ($row = mysqli_fetch_array($select)) {
    $recipients = $row['phone'];
    // Be sure to include the file you've just downloaded
    require_once('sms/AfricasTalkingGateway.php');
    // Specify your login credentials
    $username   = "Irasaac";
    $apikey     = "ede824f138f4476143bc4bee71b69c7d3be04913e9ceaff20c33409db9262020";
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

  }
?>	