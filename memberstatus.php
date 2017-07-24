<?php
	include 'db.php';
	if (isset($_GET['email']) && $_GET['email']!='') {
		$email = $_GET['email'];
		$sql = $con -> query("SELECT * FROM member WHERE member_email LIKE ('%$email%')");
		$count = mysqli_num_rows($sql);
		if ($count < 1) {
			echo '
				<p style="color: red;">Not found!!</p>
			';
		}
		else {
			echo '<p style="color: green;">yes found!! next</p>';
		}
	}

?>