<?php
	if (!isset($_GET['pro_id'])) {
		header("location: index");
	}
?>
<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
	  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- Title here -->
    	<link rel="shortcut icon" type="image/png" href="img/favicon.png">
		<title>Online Order - KCafe</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- Portfolio CSS -->
		<link href="css/prettyPhoto.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="css/font-awesome.min.css" rel="stylesheet">	
		<!-- Custom Less -->
		<link href="css/less-style.css" rel="stylesheet">	
		<!-- Custom CSS -->
		<link href="css/style.css" rel="stylesheet">
		<!--[if IE]><link rel="stylesheet" href="css/ie-style.css"><![endif]-->
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.png">
	</head>
	
	<body data-spy="scroll" data-target=".navbar" data-offset="50">
		<!-- Page Wrapper -->

		<?php include("dy_header.php"); ?>
			
			<!-- Header End -->
			<div class="wrapper">
			<!-- Inner Content -->
			<div class="inner-page padd">
				
				<?php
					$sms = "";
					$row = "";
					if (isset($_GET['pro_id'])) {
						$pro_id = $_GET['pro_id'];
					}
				?>

				<div class="container">
					<div id="page-wrapper">
						<div class="row">						
							<table border="0" width="80%" class="table table-striped table-hover" style="border-color: grey;">
								<tr>
									<td rowspan="8" width="60%">
										<div class="thumbnails zoom">
											<!-- Product image -->
											<?php
												include("db.php");
												$sqlproduct = $con ->query("SELECT * FROM products WHERE id = '$pro_id' LIMIT 1");
									      		$row = mysqli_fetch_array($sqlproduct);
									      		echo '<img class="img-responsive img-center" src="img/pro/'.$row['pic'].'" alt="'.$row['Name'].'" width="60%" style="margin: auto; margin-top: 55px;">';
											?>
						        		</div>
						        	<!-- thumbnails-image -->
									</td>
									
								</tr>
					        	<tr>
					        		<td colspan="2">
					        			<h1 class="product-name product-name-product">
											<?php
												include("db.php");
												$sqlmember = $con ->query("SELECT * FROM products WHERE id = '$pro_id' LIMIT 1");
									      		$row = mysqli_fetch_array($sqlmember);
									      		echo ''.$row['Name'].'';
											?>
										</h1>
									</td>
					        	</tr>
					          	
									<!-- Ordering form -->
								<form action="cart" method="post">
								<tr>
									<td><label>Price for member</label></td>
									<td>
									<?php
										include("db.php");
										$sqlmember = $con ->query("SELECT * FROM products WHERE id = '$pro_id' LIMIT 1");
							      		$row = mysqli_fetch_array($sqlmember);
							      		echo ''.$row['price_member'].' frw';
									?>
										
									</td>
								</tr>
								<tr>
									<td><label>Price for non member</label></td>
									<td>
									<?php
							      		$sqlnonmember = $con ->query("SELECT * FROM products WHERE id = '$pro_id' LIMIT 1");
							      		$row = mysqli_fetch_array($sqlnonmember);
							      		echo ''.$row['price_non_member'].' frw';										
									?>
										
									</td>
								</tr>
								<tr>
									<td><label>Delivery Time</label></td>
									<td>10 min</td>
								</tr>
								<tr>
									<td><label>Enter Quantity</label></td>
									<td>
										<div class="form-group">
										<input autofocus required type="text" name="qty" value="1" size="2" maxlength="4" >
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
									<div class="form-group">
										<input type="hidden" name="pid" id="pid" value="<?php echo $row['id'];?>">
										<input name="button" id="button" value="Add To Cart" type="submit" class="btn btn-danger btn-sm">
										<a href="index" class="btn btn-info btn-sm">Cancel</a>
									</div></td>
								</tr>
								</form>
							</table>
									<!--/ Table End-->
					    </div>
					</div>
				</div>
			</div>

	<!-- including dynamic footer page -->
		<?php
			include 'footer.php';
		?>
	<!-- end of including footer page -->
			
		</div><!-- / Wrapper End -->
		
		
		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-angle-up"></i></a></span> 
			
		<!-- Javascript files -->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Pretty Photo JS -->
		<script src="js/jquery.prettyPhoto.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="js/custom.js"></script>
		<!-- JS code for this page -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</body>	
</html>
