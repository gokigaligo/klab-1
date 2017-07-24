<?php
	include 'db.php';
	if (isset($_GET['nm']) && $_GET['nm']!='') {
		$Name = $_GET['nm'];
		$sql = $con -> query("SELECT * FROM products WHERE Name LIKE ('%$Name%') AND status = 'Active'");
		$count = mysqli_num_rows($sql);
		if ($count < 1) {
			echo '
				<br> <p><i>No product like "'.$Name.'" or it is unavairable</i></p>
			';
		}
		while ( $query = mysqli_fetch_array($sql) ) {
			$id = $query['id'];
			echo '<br>
				<table width="100px">
					<tr>
						<td>
							<a href="order?pro_id='.$id.'">'.$query['Name'].'</a>
						</td>
					</tr>
				</table>
			';
		}
	}

?>