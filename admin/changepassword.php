 <?php
	session_start();
	$userId ='';
	if (isset($_SESSION['klabusername'])) {
		include '../db.php';
	    $name = $_SESSION['klabusername'];
	    $password = $_SESSION['klabpassword'];
	    $selectid = $con ->query("SELECT * FROM users WHERE name='$name' AND password='$password'");
	    $fetchid = mysqli_fetch_array($selectid);
	    $userId = $fetchid['id'];
	}
	elseif (!isset($_SESSION['klabusername'])) {
	    header("location: login");
	}
?>
<?php
    $response = '';
    if(isset($_POST['Oldpass'])) {
        include '../db.php';
        $oldpass = $_POST['Oldpass'];
        $newpass= $_POST['Newpass'];
        if ($oldpass == $_SESSION['klabpassword']) {
            $updatepassword = $con ->query("UPDATE users SET password = '$newpass' WHERE password = '".$_SESSION['klabpassword']."'");
            $_SESSION['klabpassword'] = $newpass;
            echo'<p style="color:green;">password changed.</p>';
        }
        else {
            echo'<p style="color:red;">old password is incorrect.</p>';
        }
    }
?>