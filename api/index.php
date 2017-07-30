
<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") 
{
	if(isset($_POST['action']))
	{
		$_POST['action']();
	}
	else
	{
		echo $_POST['action'].'Please Read the API documentation';
	}
}
else
{
	echo 'UPLUS API V01';
}

function listGroups()
{
	include("db.php");
	$memberId		= mysqli_real_escape_string($db, $_POST['memberId']);
	$sqlgroups 		= $db->query("SELECT  u.groupId, u.syncstatus, u.groupName, u.groupTargetType, u.perPersonType, u.targetAmount, u.perPerson, u.adminId, u.adminName, u.groupDesc, r.Balance groupBalance
		FROM uplus.members u
		INNER JOIN rtgs.groupbalance r 
		WHERE u.groupId = r.groupId
		AND u.memberId = '$memberId' group by u.groupId")or die(mysqli_error());
	$groups 		= array();
	WHILE($group 	= mysqli_fetch_array($sqlgroups))
	{
		$groups[] 	= $group;
		$groupId 	= $group['groupId'];
		$sychronize = $db->query("UPDATE groups SET syncstatus = 'Yes' WHERE id ='$groupId' AND syncstatus = 'No'")or die(mysqli_error());
	}

	header('Content-Type: application/json');
	$groups = json_encode($groups);
	echo $groups;
}

function createGroup()
{
	require('db.php');
	$groupName			= mysqli_real_escape_string($db, $_POST['groupName']);
	$groupTargetType	= mysqli_real_escape_string($db, $_POST['groupTargetType']);
	$targetAmount		= mysqli_real_escape_string($db, $_POST['targetAmount']);
	$perPersonType		= mysqli_real_escape_string($db, $_POST['perPersonType']);
	$perPerson			= mysqli_real_escape_string($db, $_POST['perPerson']);
	$adminId			= mysqli_real_escape_string($db, $_POST['adminId']);
	$accountNumber		= mysqli_real_escape_string($db, $_POST['accountNumber']);
	$bankId				= mysqli_real_escape_string($db, $_POST['bankId']);
	
	$sqliAdmin = $db->query("SELECT phone FROM users WHERE id = '$adminId'");
	$countAdmins = mysqli_num_rows($sqliAdmin);
	if($countAdmins > 0)
	{
		$rowid = mysqli_fetch_array($sqliAdmin);
		$adminPhone = $rowid['phone'];
	}

	$db->query("INSERT INTO groups
		(groupName, adminId, adminPhone, 
		 targetAmount, perPerson, createdDate,
		 createdBy, state, groupTargetType, perPersonType)
		VALUES('$groupName',$adminId,'$adminPhone',
			$targetAmount, $perPerson,now(),
			$adminId,'private','$groupTargetType','$perPersonType')") or die (mysqli_error());

			$sqlid = $db->query("SELECT id FROM groups ORDER BY id DESC LIMIT 1") or die (mysqli_error());
			$rowid = mysqli_fetch_array($sqlid);
			$lastid = $rowid['id'];
	if($db)
	{
		
		$outCon->query("INSERT INTO `groups`(`groupId`, `accountNumber`, `bankId`)
		VALUES('$lastid','$accountNumber','$bankId')")or die(mysqli_error());
		
		if($outCon)
		{
			$db->query("INSERT INTO groupuser
			(`joined`, `groupId`, `userId`,`createdBy`, `createdDate`)
			VALUES('yes','$lastid','$adminId','$adminId', now())")or die(mysqli_error());
			if($db)
			{
				//listGroups();
				echo "".$lastid."";
			}
			else
			{
				echo 'The user not joined';
			}
		}
		else
		{
			// Rollback
			$db->query("DELETE FROM groups WHERE id = '$lastid'");
			echo 'Group not created, Money part not made';
		}
	}
	else
	{
		// Rollback
		$db->query("DELETE FROM groups WHERE id = '$lastid'");
		echo 'Group not created';
	}
}

function modifyGroup()
{
	require('db.php');
	$groupName			= mysqli_real_escape_string($db, $_POST['groupName']);
	$groupTargetType	= mysqli_real_escape_string($db, $_POST['groupTargetType']);
	$targetAmount		= mysqli_real_escape_string($db, $_POST['targetAmount']);
	$perPersonType		= mysqli_real_escape_string($db, $_POST['perPersonType']);
	$perPerson			= mysqli_real_escape_string($db, $_POST['perPerson']);
	$adminId			= mysqli_real_escape_string($db, $_POST['adminId']);
	$adminPhone			= mysqli_real_escape_string($db, $_POST['adminPhone']);
	$accountNumber		= mysqli_real_escape_string($db, $_POST['accountNumber']);
	$bankId				= mysqli_real_escape_string($db, $_POST['bankId']);
	$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	$state				= mysqli_real_escape_string($db, $_POST['state']);
	
	$db->query("UPDATE groups SET 
		groupName ='$groupName', adminId=$adminId, adminPhone='$adminPhone', 
		targetAmount=$targetAmount, perPerson='$perPerson', updatedDate= now(),
		updatedBy='$adminId', groupTargetType='$groupTargetType', perPersonType='$perPersonType'
		, state='$state' WHERE id= '$groupId'
		") or die (mysqli_error());
	
	if($db)
	{
		
		$outCon->query("UPDATE groups SET 
		 accountNumber='$accountNumber', bankId='$bankId'
		WHERE groupId = '$groupId'
		")or die(mysqli_error());
		
		if($outCon)
		{ 
			//listGroups();
		}
		else
		{
			echo 'money part not UPDATED';
		}
	}
	else
	{
		'group not UPDATED';
	}
}

function deleteGroup()
{
	require('db.php');
	$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	$adminId			= mysqli_real_escape_string($db, $_POST['adminId']);
	$db->query("UPDATE groups SET 
		archive ='yes'
		WHERE id='$groupId' AND adminId=$adminId
		") or die (mysqli_error());
	
	if($db)
	{
		//listGroups();
	}
	else
	{
		'you cant delete this group';
	}
}

function inviteMember()
{
	require('db.php');
	echo ' -> groupId '.$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	echo '<br/> -> invitorId '.$invitorId			= mysqli_real_escape_string($db, $_POST['invitorId']);
	echo '<br/> -> invitedPhone '.$invitedPhone		= mysqli_real_escape_string($db, $_POST['invitedPhone']);
	
}

function listMembers()
{
	require('db.php');
	$groupId	= mysqli_real_escape_string($db, $_POST['groupId']);
	$sqlMembers = $db->query("SELECT `groupId`, `syncstatus`, `groupName`, `groupTargetType`, `perPersonType`, `targetAmount`, `perPerson`, `adminId`, `adminName`, `groupDesc`, `memberId`, `memberPhone`, COALESCE(`memberName`, `memberPhone`) `memberName` FROM `members` WHERE groupId = '$groupId'") or die(mysqli_error());
	$members = array();
	WHILE($member = mysqli_fetch_array($sqlMembers))
	{
		$members[] = array(
		   "memberId"        => $member['memberId'],
		   "memberPhone"        => $member['memberPhone'],
		   "memberName"        	=> $member['memberName'],
		   "groupId"        	=> $member['groupId']
		   );
		
	}	
	header('Content-Type: application/json');
	echo $members = json_encode($members);
}

function signup()
{
	require('db.php');
	$phoneNumber	= mysqli_real_escape_string($db, $_POST['phoneNumber']);
	$sqlcheckPin = $db->query("SELECT *  FROM users WHERE phone = '$phoneNumber' LIMIT 1");
	$countPin = mysqli_num_rows($sqlcheckPin);
	$signInfo = array();
	if($countPin > 0)
	{
		while ($rowpin = mysqli_fetch_array($sqlcheckPin)) {
			$code = $rowpin['password'];
			$signInfo = array(
		   		"pin"        => $rowpin['password'],
		   		"userId"     => $rowpin['id'],
		   		"userName"   => $rowpin['name']
		   );
		}
	}else
	{
		$code = rand(1000, 9999);
		$sqlsavePin = $db->query("INSERT INTO `users`(
		phone, active, createdDate, password,visits) 
		VALUES('$phoneNumber','0',now(),'$code','0')")or die (mysqli_error());

		$sqlcheckPin = $db->query("SELECT *  FROM users ORDER BY id DESC LIMIT 1");
		while ($rowpin = mysqli_fetch_array($sqlcheckPin)) {
			$code = $rowpin['password'];
			$signInfo = array(
		   		"pin"        => $rowpin['password'],
		   		"userId"     => $rowpin['id'],
		   		"userName"   => $rowpin['name']
		   );
		}
	}
	$results="";
	// 'went to require sms class';
	require_once('sms.php');
	$username   = "cmuhirwa";
	$apikey     = "2b11603e7dc4c35a64bfdda3ad8d78e48db8a4afc9032a2a57209ba902a21154";
	$recipients = '+25'.$phoneNumber;
	$message    = 'Welcome to UPLUS, please use '.$code.' to log into your account.';// Specify your AfricasTalking shortCode or sender id
	$from = "uplus";

	$gateway    = new AfricasTalkingGateway($username, $apikey);

	try 
	{
		$results = $gateway->sendMessage($recipients, $message, $from);
		
		header('Content-Type: application/json');
		$signInfo = json_encode($signInfo);
		echo '['.$signInfo.']';

	}
	catch (AfricasTalkingGatewayException $e)
	{
		$results.="Encountered an error while sending: ".$e->getMessage();
		echo $results;
	}
}

function updateProfile(){
	require('db.php');
	$userId				= mysqli_real_escape_string($db, $_POST['userId']);
	$userName			= mysqli_real_escape_string($db, $_POST['userName']);
	$db->query("UPDATE users SET name = '$userName', active = 1, last_visit = now(), visits = 1 WHERE id = '$userId'")or die(mysqli_error());
	if($db)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

function contribute(){

	$memberId	= $_POST['memberId'];
	$groupId	= $_POST['groupId'];
	$amount 	= $_POST['amount'];
	$fromPhone	= $_POST['fromPhone'];
	$bankId		= $_POST['bankId'];

	require('db.php');
	// GET USER'S INFROMATION
	include("db.php");
	$sql = $db->query("SELECT groupName, memberName FROM members WHERE groupId = '$groupId' AND memberId = '$memberId' LIMIT 1");
	
	if($db)
	{
		while($row = mysqli_fetch_array($sql))
		{
			$groupName 		= $row['groupName'];
			$memberName		= $row['memberName'];
		}

		// SAVE THE TRANSACTION TO THE UPLUS DATABASE

		$outCon->query("INSERT INTO grouptransactions(
			memberId, groupId, amount, fromPhone, 
			bankId, operation, status)
		 	VALUES ('$memberId', '$groupId', '$amount', '$fromPhone', 
		 	'$bankId', 'DEBIT', 'CALLED')")
		 	 or mysqli_error();

		if($outCon){
			$sqlRemovedId= $outCon->query("SELECT id FROM grouptransactions ORDER BY id DESC LIMIT 1");
			$remId = mysqli_fetch_array($sqlRemovedId);
			$contTransactionId = $remId['id'];

			//Get the bank name
			$sqlNotifyBank 	= $outCon->query("SELECT name FROM banks WHERE id = '$bankId'");
			$rowNotifyBank 	= mysqli_fetch_array($sqlNotifyBank);
			$notifyBank 	= $rowNotifyBank['name'];
			$notifyTitle 	= $groupName;

			// CALL API

			$url = 'https://lightapi.torque.co.rw/requestpayment/';
		
			$data = array();
			$data["agentName"] 		= "UPLUS";
			$data["agentId"] 		= "0784848236";
			$data["phone"] 			= $fromPhone;
		    $data["phone2"] 		= '';
			$data["amount"] 		= $amount;
			$data["fname"] 			= $memberName;
			$data["policyNumber"]	= ''.$groupName.' / group: '.$memberName.'';
		    $options = array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($data)
				)
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) 
			{ 
				$Update= $outCon->query("UPDATE grouptransactions SET status='NETWORK ERROR' WHERE id = '$contTransactionId'");
				
				echo 'Sorry! We had some network problem connecting to '.$notifyBank.'.<br> Please try again.';	
			}
			else
			{

				$result;
				// FROM JSON TO PHP
				$firstcheck 	= json_decode($result);
				$time 			= mysqli_real_escape_string($db,$firstcheck->{'time'});
				$transactionId 	= mysqli_real_escape_string($db,$firstcheck->{'transactionId'});
				$policyNumber 	= mysqli_real_escape_string($db,$firstcheck->{'policyNumber'});
				$invoiceNumber 	= mysqli_real_escape_string($db,$firstcheck->{'invoiceNumber'});
				$phone 			= mysqli_real_escape_string($db,$firstcheck->{'phone'});
				$phone2 		= mysqli_real_escape_string($db,$firstcheck->{'phone2'});
				$amount 		= mysqli_real_escape_string($db,$firstcheck->{'amount'});
				$fname 			= mysqli_real_escape_string($db,$firstcheck->{'fname'});
				$lname 			= mysqli_real_escape_string($db,$firstcheck->{'lname'});
				$nationalId 	= mysqli_real_escape_string($db,$firstcheck->{'nationalId'});
				$information 	= mysqli_real_escape_string($db,$firstcheck->{'information'});
				$information2 	= mysqli_real_escape_string($db,$firstcheck->{'information2'});
				$agentName 		= mysqli_real_escape_string($db,$firstcheck->{'agentName'});
				$agentId 		= mysqli_real_escape_string($db,$firstcheck->{'agentId'});
				$feedback 		= mysqli_real_escape_string($db,$firstcheck->{'feedback'});
				$balance 		= mysqli_real_escape_string($db,$firstcheck->{'balance'});
				


				$outCon->query("INSERT INTO 
					mnoapi(
					`time`, `transactionId`, `policyNumber`, `invoiceNumber`,
					 `phone`, `phone2`, `amount`, `fname`, 
					 `lname`, `nationalId`, `information`, `information2`, 
					 `agentName`, `agentId`, `feedback`, `balance`, myid)
					VALUES(
					now(), $transactionId, '$policyNumber', '$invoiceNumber',
					'$phone', '$phone2', '$amount', '$fname', 
					'$lname', '$nationalId', '$information', '$information2', 
					'$agentName', '$agentId', '$feedback', '$balance', $contTransactionId
					)
				")or die(mysqli_error());

					$returnedinformation	= array();
				
					$returnedinformation[] = array(
				       		"transactionId" => $contTransactionId,
				       		"status" => $information
				    	);
					header('Content-Type: application/json');
					$returnedinformation = json_encode($returnedinformation);
					echo $returnedinformation;
			}
		}
		else{
			echo 'error inserting a transation';
		}
	}
}
	
function checkstatus(){
	$transactionId = $_POST['transactionId'];
	
	require('db.php');
	$sql = $outCon->query("SELECT * FROM mnoapi WHERE myid = '$transactionId' ORDER BY id DESC LIMIT 1");
		// CALL API
	$url = 'https://lightapi.torque.co.rw/requestpayment/';
	$data = array();
	while($row = mysqli_fetch_array($sql))
	{
		$data[] = array(
    		"time"			=> $row['time'],
    		"transactionId" =>  (int)  $row['transactionId'],
		    "policyNumber" 	=> $row['policyNumber'],
		    "invoiceNumber" => $row['invoiceNumber'],
		    "phone" 		=>  (int)  $row['phone'],
		    "phone2" 		=>  (int) $row['phone2'],
		    "amount" 		=> (int) $row['amount'],
		    "fname" 		=> $row['fname'],
		    "lname" 		=> $row['lname'],
		    "nationalId" 	=> $row['nationalId'],
		    "information" 	=> $row['information'],
		    "information2" 	=> $row['information2'],
		    "agentName" 	=> $row['agentName'],
		    "agentId" 		=> $row['agentId'],
		    "feedback" 		=> $row['feedback'],
		    "balance" 		=> $row['balance']
		    );
	}
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) 
	{ 
		$Update= $outCon->query("UPDATE grouptransactions SET status='NETWORK ERROR' WHERE id = '$transactionId'");
		
		echo 'Sorry! We had some network problem connecting to '.$notifyBank.'.<br> Please try again.';	
	}
	else
	{
		$result;
			// FROM JSON TO PHP
		$firstcheck 	= json_decode($result);
		$information 	= mysqli_real_escape_string($db,$firstcheck->{'information'});
		$Update= $outCon->query("UPDATE grouptransactions SET status='NETWORK ERROR' WHERE id = '$transactionId'");
		
		echo $information ;
	}
}
?>