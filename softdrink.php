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
			
			<div class="banner padd" style="padding: 120px; background-size: cover;">
				<div class="container">
					<!-- Image -->
					<img class="img-responsive" src="img/crown-white.png" alt="" />
					<!-- Heading -->
					<a href="all#category"><h2 class="orange">Order Online</h2></a>
					<div class="clearfix"></div>
				</div>
			</div>
			
			<!-- Banner End -->

			<div id="category" id="innerpage" class="inner-page padd">
				<!-- Shopping Start -->
				<div class="shopping">
					<div class="container">
						<!-- Shopping items content -->
						<div class="shopping-content">
							<div class="row">
							<?php
								include("db.php");
								$record_per_page = 8;
								$page = '';
								if (isset($_GET['page'])) {
									$page = $_GET['page'];
								}
								else{
									$page = 1;
								}
								$start = ($page - 1) * $record_per_page;
								$sqlAll = $con->query("SELECT * FROM products WHERE category = 'others' AND status = 'Active'");
								while($row = mysqli_fetch_array($sqlAll))
								{
									if ($row['price_member'] == $row['price_non_member']) {
										$Paragraph = '
										';
									}
									else {
										$Paragraph = '
											<p>For kLab Members, the price is <strong>'.number_format($row['price_member']).' FRW</strong></p>
										';
									}
									echo'
										<div style="max-height: 370px; min-height: 370px;" class="col-md-3 col-sm-6">
											<!-- Shopping items -->
											<div style="max-height: 350px; min-height: 350px;" class="shopping-item">
												<!-- Image -->
												<a href="order?pro_id='.$row['id'].'"><img style="margin: auto;" class="img-responsive" src="img/pro/'.$row['pic'].'" alt="'.$row['Name'].'" /></a>
												<!-- Shopping item name / Heading -->
												<h4 class="pull-left">
													<a href="order?pro_id='.$row['id'].'">'.$row['Name'].'</a>
												</h4>
												<span class="item-price pull-right">
													'.number_format($row['price_non_member']).' FRW
												</span>
												<div class="clearfix"></div>
												<!-- Paragraph -->
												'.$Paragraph.'
												<!-- Buy now button -->
												<div class="visible-xs">
													<a class="btn btn-coffee btn-sm" href="order?pro_id='.$row['id'].'">
														Buy Now
													</a>
												</div>
												<!-- Shopping item hover block & link -->
												<div class="item-hover br-coffee hidden-xs"></div>
												<a class="link hidden-xs" href="order?pro_id='.$row['id'].'">Add to cart</a>
											</div>
										</div>
									';
								}
							?>
							</div>
							<!-- Pagination -->
							
							<!-- Pagination end-->
						</div>
					</div>
				</div>
				
				<!-- Shopping End -->
				
			</div>
				
			<!-- Footer Start -->
			<?php include 'footer.php'; ?>
			<!-- Footer End -->
			
		</div><!-- / Wrapper End -->
		
		
		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-angle-up"></i></a></span> 
		
		
		
		<!-- Javascript files -->
		<!-- auto search  -->
		<script src="js/auto.js"></script>
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
		<script>
		
		</script>
	</body>	
</html>