
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
	$groupId			= mysqli_real_escape_string($db, $_POST['groupId']);
	$invitorId			= mysqli_real_escape_string($db, $_POST['invitorId']);
	$invitedPhone		= mysqli_real_escape_string($db, $_POST['invitedPhone']);
	$sql = $db->query("SELECT id FROM users WHERE phone =  $invitedPhone");
	$countUsers = mysqli_num_rows($sql);
	if($countUsers > 0)
	{
		$invitedArray = mysqli_fetch_array($sql);
		$invitedId = $invitedArray['id'];
	}
	else
	{
		$db->query("INSERT INTO users (phone,createdBy,createdDate) VALUES  ('$invitedPhone', '$invitorId', now())");
		if($db)
		{
			$sql = $db->query("SELECT id FROM users ORDER BY id DESC LIMIT 1");
			$invitedArray = mysqli_fetch_array($sql);
			$invitedId = $invitedArray['id'];

		}
	}
	
	$db->query("INSERT INTO groupuser (joined, groupId, userId, createdBy, createdDate) VALUES ('yes','$groupId','$invitedId','$invitorId', now())");

	if($db)
	{
		$gnamesql = $db->query("SELECT name FROM groups WHERE id = '$groupId' LIMIT 1");
		$loopg = mysqli_fetch_array($gnamesql);
		$groupName = $loopg['name'];
		require_once('sms.php');
		$username   = "cmuhirwa";
		$apikey     = "2b11603e7dc4c35a64bfdda3ad8d78e48db8a4afc9032a2a57209ba902a21154";
		$recipients = '+25'.$invitedPhone;
		$message    = 'You have been invited to join '.$groupName.' (a contribution group on uplus). Install uplus to start. on http://104.236.26.9/app/';// Specify your AfricasTalking shortCode or sender id
		$from = "uplus";

		$gateway    = new AfricasTalkingGateway($username, $apikey);

		try 
		{
			$results = $gateway->sendMessage($recipients, $message, $from);
			//listGroups();
		}
		catch (AfricasTalkingGatewayException $e)
		{
			$results.="Encountered an error while sending: ".$e->getMessage();
			echo 'error';
		}
	}
	else
	{
		'The user is not invited';
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


	
?>
