<?php
	if (isset($_GET['orderid'])) {
		$orderid = $_GET['orderid'];
		include '../db.php';
		$selectorder = $con -> query("SELECT * FROM orders WHERE conf_id = '$orderid'");
		$orderview = mysqli_fetch_array($selectorder);
		echo '
			<div class="row">
				<div class="col-md-4"></div>
				<form enctype="multipart/form-data" method="post" action="action.php">
					<div class="col-md-4">
		        		<select name="status" class="form-control">
		        			<option>'.$orderview['status'].'</option>
		        			<option>Receive</option>
		        			<option>Reject</option>
		        			<option>delivered</option>
		        		</select>
		        		<input type="hidden" value="'.$orderid.'" name="id">
			        </div>
					<div class="col-md-2">
			        	<input type="submit" value="Update" class="btn btn-sm btn-info" name="update">
					</div>
				</form>
				<div class="col-md-2"></div>
			</div>

        ';

	}

?>
