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
	$sqlgroups 		= $db->query("SELECT u.groupId, u.updatedDate , u.syncstatus, u.groupName, u.groupTargetType, u.perPersonType, u.targetAmount, u.perPerson, u.adminId, u.adminName, u.groupDesc, r.Balance groupBalance
		FROM uplus.members u
		INNER JOIN rtgs.groupbalance r 
		WHERE u.groupId = r.groupId
		AND u.memberId = '$memberId' group by u.groupId")or die(mysqli_error());
	$groups 		= array();
	WHILE($group 	= mysqli_fetch_array($sqlgroups))
	{
		$groups[] 	= $group;
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
	$imageoldname		= mysqli_real_escape_string($db, $_POST['imageoldname']);
	
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
		 createdBy, state, groupTargetType, perPersonType, updatedBy, updatedDate)
		VALUES('$groupName',$adminId,'$adminPhone',
			$targetAmount, $perPerson,now(),
			$adminId,'private','$groupTargetType','$perPersonType', '$adminId', now())") or die (mysqli_error($db));



	if($db)
	{
		$sqlid = $db->query("SELECT id FROM groups ORDER BY id DESC LIMIT 1") or die (mysqli_error());
		$rowid = mysqli_fetch_array($sqlid);
		$lastid = $rowid['id'];
		
		$db->query("INSERT INTO groupuser
		(`joined`, `groupId`, `userId`,`createdBy`, `createdDate`, updatedBy, updatedDate)
		VALUES('yes','$lastid','$adminId','$adminId', now(), '$adminId', now())")or die(mysqli_error());

		if(!$imageoldname == 0)
		{
			rename("../groupimg/".$imageoldname, "../groupimg/".$lastid."jpg");
		}

		if($db)
		{
			echo "".$lastid."";
		}
		else
		{
			// Rollback
			$db->query("DELETE FROM groups WHERE id = '$lastid'");
			echo 'The user not joined';
		}
	}
	else
	{
		echo 'Group not created';
	}
}

function createcollection()
{
	require('db.php');
	$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	$accountNumber		= mysqli_real_escape_string($db, $_POST['accountNumber']);
	$bankId				= mysqli_real_escape_string($db, $_POST['bankId']);
	
	//CHECH IF THE ACCOUNT WASENT THERE BEFORE:
	$sql = $outCon->query("SELECT id FROM groups WHERE groupId= '$groupId' LIMIT 1");
	$check = mysqli_num_rows($sql);
	if($check > 0)
	{
		$row = mysqli_fetch_array($sql);
		$collectionId = $row['id'];
		$sql =  $outCon->query("UPDATE groups SET groupId = '$groupId', accountNumber = '$accountNumber', bankId = '$bankId' WHERE id = '$collectionId'");	
		echo 'updated the existing account';
	}
	else
	{
		$outCon->query("INSERT INTO groups(groupId, accountNumber, bankId)
		VALUES('$groupId','$accountNumber','$bankId')")or die(mysqli_error());
		
		if($outCon)
		{
			echo'Collection account added';
		}
		else
		{
			echo 'Collection account is not created';
		}
	}
}

function modifyGroup()
{
	require('db.php');
	$groupName			= mysqli_real_escape_string($db, $_POST['groupName']);
	$groupTargetType		= mysqli_real_escape_string($db, $_POST['groupTargetType']);
	$targetAmount			= mysqli_real_escape_string($db, $_POST['targetAmount']);
	$perPersonType			= mysqli_real_escape_string($db, $_POST['perPersonType']);
	$perPerson			= mysqli_real_escape_string($db, $_POST['perPerson']);
	$adminId			= mysqli_real_escape_string($db, $_POST['adminId']);
	$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	
	$db->query("UPDATE groups SET 
		groupName ='$groupName', 
		targetAmount=$targetAmount, perPerson='$perPerson', updatedDate= now(),
		updatedBy='$adminId', groupTargetType='$groupTargetType', perPersonType='$perPersonType'
		, WHERE id= '$groupId' AND adminId = '$adminId'
		") or die (mysqli_error($db));
	
	if($db)
	{
		echo 'thanks the group is updated';
	}
	else
	{
		'group not UPDATED';
	}
}

// NO ONE SHOULD EVER DELETE A GROUP, INSTEAD HE SHOULD LEAVE IT TO OTHERS 
function deleteGroup()
{
	require('db.php');
	$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	$adminId			= mysqli_real_escape_string($db, $_POST['adminId']);
	$db->query("UPDATE groups SET 
		archive ='yes', archivedDate = now(), archivedBy = '$adminId'
		WHERE id='$groupId' AND adminId=$adminId
		") or die (mysqli_error());
	
	if($db)
	{
		'the group is Deleted';
	}
	else
	{
		'you cant delete this group';
	}
}

function inviteMember()
{
	require('db.php');
	$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	$invitorId			= mysqli_real_escape_string($db, $_POST['invitorId']);
	$invitedPhone		= mysqli_real_escape_string($db, $_POST['invitedPhone']);

	$sql = $db->query("SELECT id FROM users WHERE phone =  $invitedPhone") or (mysqli_error());
	$countUsers = mysqli_num_rows($sql);
	if($countUsers > 0)
	{
		$invitedArray = mysqli_fetch_array($sql);
		$invitedId = $invitedArray['id'];
	}
	else
	{
		$code = rand(0000, 9999);
		$db->query("INSERT INTO 
			users (phone,createdBy,createdDate, password, updatedBy, updatedDate) 
			VALUES  ('$invitedPhone', '$invitorId', now(), '$code', 'invitorId', now() )
			");
		if($db)
		{
			$sql 			= $db->query("SELECT id FROM users ORDER BY id DESC LIMIT 1");
			$invitedArray 	= mysqli_fetch_array($sql);
			$invitedId 		= $invitedArray['id'];

			// CEATE THE MONEY ACCOUNT FOR THE PERSON
			//$sqlmoney = $outCon->query("INSERT INTO members ");
		}
	}

	// CHECK IF THE USER IS ALREADY IN THE GROUP
	$sql = $db->query("SELECT * FROM groupuser WHERE groupId ='$groupId' AND userId='$invitedId'");
	$checkExits = mysqli_num_rows($sql);
	if($checkExits > 0)
	{
		echo 'This member with '.$invitedPhone.', is already a member of this group';
	}
	else
	{
		
		$sql = $db->query("INSERT INTO groupuser (joined, groupId, userId, createdBy, createdDate, updatedBy, updatedDate) 
			VALUES ('yes','$groupId','$invitedId','$invitorId', now(), '$invitorId', now())")or die(mysqli_error());

		if($db)
		{
			$gnamesql = $db->query("SELECT groupName FROM groups WHERE id = '$groupId' LIMIT 1");
			$loopg 		= mysqli_fetch_array($gnamesql);
			$groupName = $loopg['groupName'];
			require_once('sms.php');
			$username   = "cmuhirwa";
			$apikey     = "2b11603e7dc4c35a64bfdda3ad8d78e48db8a4afc9032a2a57209ba902a21154";
			$recipients = '+25'.$invitedPhone;
			$message    = 'You have been invited to join '.$groupName.' (a contribution group on uplus). Install uplus to start. on http://104.236.26.9/app/';// Specify your AfricasTalking shortCode or sender id
			$from = "uplus";

			$gateway    = new AfricasTalkingGateway($username, $apikey);

			// try 
			// {
			// 	$results = $gateway->sendMessage($recipients, $message, $from);
			 	echo 'Member with '.$invitedPhone.' is Invited';
				//listGroups();
			// }
			// catch (AfricasTalkingGatewayException $e)
			// {
			// 	$results.="Encountered an error while sending: ".$e->getMessage();
			// 	echo 'error';
			// }
		}
		else
		{
			'The user is not invited';
		}
	}	
}

function exitGroup()
{
	include "db.php";
	$groupId 	= $_POST['groupId'];
	$memberId 	= $_POST['memberId'];	
	
	$sql = $db->query("UPDATE groupuser SET archive = 'YES', archivedDate = now() WHERE groupId = '$groupId' AND userId = '$memberId'")or die(mysqli_error($db));
	if($db)
	{
		echo 'You are no longer a member of this group.';
	}
	else
	{
		echo 'You are not in this group.';
	}
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
		phone, active, createdDate, password,visits, updatedBy, updatedDate) 
		VALUES('$phoneNumber','0',now(),'$code','0', '1', now())")or die (mysqli_error());

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

	//try 
	//{
		//$results = $gateway->sendMessage($recipients, $message, $from);
		
		header('Content-Type: application/json');
		$signInfo = json_encode($signInfo);
		echo '['.$signInfo.']';

	//}
	//catch (AfricasTalkingGatewayException $e)
	//{
	//	$results.="Encountered an error while sending: ".$e->getMessage();
	//	echo $results;
	//}
}

function updateProfile()
{
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

function contribute()
{

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

		$sql = $outCon->query("INSERT INTO grouptransactions(
			memberId, groupId, amount, fromPhone, 
			bankId, operation, status, updatedBy, updatedDate)
		 	VALUES ('$memberId', '$groupId', '$amount', '$fromPhone', 
		 	'$bankId', 'DEBIT', 'CALLED', '1', now())")
		 	 or mysqli_error($outCon);

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
				$id 			= mysqli_real_escape_string($db,$firstcheck->{'id'});
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
				


				$sql = $outCon->query("INSERT INTO 
					mnoapi(
					apiId,
					`time`, `transactionId`, `policyNumber`, `invoiceNumber`,
					 `phone`, `phone2`, `amount`, `fname`, 
					 `lname`, `nationalId`, `information`, `information2`, 
					 `agentName`, `agentId`, `feedback`, `balance`, myid)
					VALUES(
					$id, 
					'$time', '$transactionId', '$policyNumber', '$invoiceNumber',
					'$phone', '$phone2', '$amount', '$fname', 
					'$lname', '$nationalId', '$information', '$information2', 
					'$agentName', '$agentId', '$feedback', '$balance', $contTransactionId
					)
				")or die(mysqli_error($outCon));

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
	
function checkstatus()
{
	$myId = $_POST['transactionId'];
	
	require('db.php');
	$sql = $outCon->query("SELECT * FROM mnoapi WHERE myid = '$myId' ORDER BY id DESC LIMIT 1");
		// CALL API
	$url = 'https://lightapi.torque.co.rw/requestpayment/';
	$data = array();
	while($row = mysqli_fetch_array($sql))
	{
		$data[] = array(
    		"id"			=> (int) $row['apiId'],
    		"time"			=> $row['time'],
    		"transactionId" => $row['transactionId'],
		    "policyNumber" 	=> $row['policyNumber'],
		    "invoiceNumber" => $row['invoiceNumber'],
		    "phone" 		=> $row['phone'],
		    "phone2" 		=> $row['phone2'],
		    "amount" 		=> $row['amount'],
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

	$data = json_encode($data);
	$data  = trim($data, '[');
	$data  = trim($data, ']');
	$data;

	$data = json_decode($data);
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
		$Update= $outCon->query("UPDATE grouptransactions SET status='NETWORK ERROR' WHERE id = '$myId'");
		
		echo 'Sorry! We had some network problem connecting to '.$notifyBank.'.<br> Please try again.';	
	}
	else
	{
		$result;
			// FROM JSON TO PHP
		$firstcheck 	= json_decode($result);
		$id 			= mysqli_real_escape_string($db,$firstcheck->{'id'});
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
		


		$sql = $outCon->query("INSERT INTO 
			mnoapi(
			apiId,
			`time`, `transactionId`, `policyNumber`, `invoiceNumber`,
			 `phone`, `phone2`, `amount`, `fname`, 
			 `lname`, `nationalId`, `information`, `information2`, 
			 `agentName`, `agentId`, `feedback`, `balance`, myid)
			VALUES(
			$id, 
			'$time', '$transactionId', '$policyNumber', '$invoiceNumber',
			'$phone', '$phone2', '$amount', '$fname', 
			'$lname', '$nationalId', '$information', '$information2', 
			'$agentName', '$agentId', '$feedback', '$balance', $myId
			)
		")or die(mysqli_error($outCon));

			$returnedinformation	= array();
		
			$returnedinformation[] = array(
		       		"transactionId" => $myId,
		       		"status" => $information
		    	);
			header('Content-Type: application/json');
			$returnedinformation = json_encode($returnedinformation);
			echo $returnedinformation;
	}
}

function withdrawrequest()
{
	include('db.php');
	$groupId			= $_POST['groupId'];
	$amount 			= $_POST['amount'];
	$memberId 			= $_POST['memberId'];
	$withdrawAccount 	= $_POST['withdrawAccount'];
	$withdrawBank 		= $_POST['withdrawBank'];

	$sqlCheck 	= $outCon->query("SELECT id FROM withdrowrequests WHERE userId = '$memberId' AND (groupId = '$groupId' AND status = 'PENDING')");
	$counted 	= mysqli_num_rows($sqlCheck);
	if(!$counted > 0)
	{
		$sqlreq = $outCon->query("INSERT INTO withdrowrequests(amount, userId, groupId, withdrawAccount, withdrawBank, status, createdDate, createdBy, updatedBy, updatedDate)
		 VALUES ('$amount','$memberId', '$groupId', '$withdrawAccount', '$withdrawBank', 'PENDING', now(),'$memberId', '$memberId', now())")or die (mysqli_error($outCon));
		if($outCon){
			echo 'Your request has been sent.';
		}
	}
	else
	{
		echo 'Please wait for the first request.';
	}
}

function withdrawlist()
{
	include("db.php");
	$groupId		= mysqli_real_escape_string($db, $_POST['groupId']);
	$sqlwithdraw	= $outCon->query("SELECT * FROM withdrowrequests WHERE groupId = '$groupId' AND status = 'PENDING'")or die(mysqli_error($outCon));
	$withdraws 		= array();
	WHILE($withdraw = mysqli_fetch_array($sqlwithdraw))
	{
		$withdraws[] 	= $withdraw;
	}

	header('Content-Type: application/json');
	$withdraws = json_encode($withdraws);
	echo $withdraws;
}

function withdrawapprove()
{
	include("db.php");
	$requestId		= mysqli_real_escape_string($db, $_POST['requestId']);
	$treasurerId	= mysqli_real_escape_string($db, $_POST['treasurerId']);
	
	$sqlCheck 	= $outCon->query("SELECT * FROM requestsdecisions WHERE requestId = '$requestId' AND  createdBy = '$treasurerId'");
	$counted 	= mysqli_num_rows($sqlCheck);
	if(!$counted > 0)
	{
		$sqlreq = $outCon->query("
		INSERT INTO requestsdecisions(requestId, vote, createdBy, createdDate, updatedBy, updatedDate) 
		VALUES ($requestId, 'YES', '$treasurerId', now(), '$treasurerId', now())")or die(mysqli_error($outCon));
		echo 'Thanks for your vote on this request.';
	}
	else
	{
		echo 'You have voted already.';
	}
}

function withdrawreject()
{
	include("db.php");
	$requestId		= mysqli_real_escape_string($db, $_POST['requestId']);
	$treasurerId	= mysqli_real_escape_string($db, $_POST['treasurerId']);
	
	$sqlCheck 	= $outCon->query("SELECT * FROM requestsdecisions WHERE requestId = '$requestId' AND  createdBy = '$treasurerId'");
	$counted 	= mysqli_num_rows($sqlCheck);
	if(!$counted > 0)
	{
		$sqlreq = $outCon->query("
		INSERT INTO requestsdecisions(requestId, vote, createdBy, createdDate, updatedBy, updatedDate) 
		VALUES ($requestId, 'NO', '$treasurerId', now(), '$treasurerId', now())")or die(mysqli_error());
		echo 'Thanks for your vote on this request.';
	}
	else
	{
		echo 'You have voted already.';
	}
}
?>
