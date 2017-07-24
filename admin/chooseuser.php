<?php
	include '../db.php';
	if (isset($_GET['userId'])) {
		$fetchuseraccount = $con ->query("SELECT * FROM users WHERE id = '".$_GET['userId']."'");
		$getaccount = mysqli_fetch_array($fetchuseraccount);
		$useraccount =  $getaccount['category'];
		if ($useraccount == 'standard') {
				?>
			<script type="text/javascript">
				document.location.href = 'settingstandard';
			</script>
				<?php
		}
		else {
				?>
			<script type="text/javascript">
				document.location.href = 'settings';
			</script>
				<?php
		}
	}
	else {
		?>
	<script type="text/javascript">
		document.location.href = 'index';
	</script>
		<?php
	}

?>