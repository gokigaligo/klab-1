<?php
	$response = "";
	include 'db.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
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
		<link rel="shortcut icon" type="image/png" href="img/favicon.png">
	</head>
	
	<body data-spy="scroll" data-target=".navbar" data-offset="50">
		
		
		<!-- Page Wrapper -->
		<div class="wrapper">

			<!-- header start -->
				
			<?php include("dy_header.php") ?>

			<!-- Header End -->
			
			<!-- Banner Start -->
			
			<div class="banner padd" style="padding: 100px; background-size: cover;">
				<div class="container">
					<!-- Image -->
					<img class="img-responsive" src="img/crown.png" alt="" />
					<!-- Heading -->
						<h2 class="orange">cart</h2>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- Banner End -->

			<div class="container">
				<div id="page-wrapper">	
					<div class="row">
						<div class="col-md-12">
						<?php 
							if (!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1) {
								echo $cartvide;
							}
							else{
								echo '
									<div class="table table-responsive">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>N0</th>
													<th>Product</th>
													<th>Quantity</th>
													<th>Unit Price Member </th>
													<th>unit Price Non Member </th>
													<th>Total Member Price</th>
													<th>Total Non Member Price</th>
													<th>Remove</th>
												</tr>
											</thead>
											'.$cartOutput.'
											<tr>
												<th>Total</th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th>'.$cartTotalM.' Frw for member</th>
												<th>'.$cartTotal.' Frw for non member</th>
												<th></th>
											</tr>
										</table>
									</div>
						    			<a href="cart?cmd=emptycart"><strong>Empty Your Shopping Cart here</strong></a>
									';
									echo '
										<div class="row">
											<div class="col-md-3">
												<a href="all#category" type="button" class="btn btn-info">Continue Order</a>
											</div>
											<div class="col-md-6"></div>
											<div class="col-md-3">
												<a href="payrol" type="button" class="btn btn-success">Checkout</a>
											</div>
										</div>
									';
							}
						?>
						</div>
				    </div>
				</div>
			</div>
			<?php
				include 'footer.php';
			?>
</body>
</html>