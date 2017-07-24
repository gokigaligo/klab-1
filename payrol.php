
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
		<link rel="shortcut icon" href="#">
		<style type="text/css">
			#response {
			  display: none;
			  text-align: center;
			}
			.pay {
				display: none;
			}
			/* Center the loader */
			#loader {
				display: none;
				position: absolute;
				left: 50%;
				top: 50%;
				z-index: 1;
				width: 40px;
				height: 40px;
				margin: -75px 0 0 -75px;
				border: 1px solid #f3f3f3;
				border-radius: 50%;
				border-top: 1px solid black;
				-webkit-animation: spin 2s linear infinite;
				animation: spin 2s linear infinite;
			}

			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			  0% { transform: rotate(0deg); }
			  100% { transform: rotate(360deg); }
			}
		</style>
	</head>	
	<?php include("dy_header.php") ?>
	<?php
		if (!isset($_SESSION['cart_array']) || $_SESSION['cart_array'] < 1) {
			?>
				<script type="text/javascript">
					window.location.href = 'index';
				</script>
			<?php
		}
	?>

	<div class="wrapper">	<!-- Page Wrapper -->
		
		<div class="banner padd" style="padding: 120px; background-size: cover;">	<!-- Banner Start -->
			<div class="container">
				<!-- Image -->
				<img class="img-responsive" src="img/crown.png" alt="" />
				<!-- Heading -->
				<h2 class="orange">Checkout</h2>
				<div class="clearfix"></div>
			</div>
		</div>	<!-- Banner End -->

		<div class="inner-page padd">	<!-- Inner Content -->
		
			<div class="checkout">	<!-- Checkout Start -->

				<div id="infoDiv" class="container">	<!-- container and infoDiv id start -->

					<center><h4>Fill To Confirm</h4></center>

					<div class="row">	<!-- start div of  total cart payment -->
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<center>
								<h4 style="padding: 30px 20px; border: solid 2px black; border-radius: 10px;text-align: center; background-color: lightgreen;"><?php echo 'Total cart payment for non member: '.$cartTotal.' Frw'?>
								</h4>
								<h4 style="padding: 30px 20px; border: solid 2px black; border-radius: 10px;text-align: center; background-color: lightblue;"><?php echo 'Total cart payment for member: '.$cartTotalM.' Frw'?>
								</h4>
							</center>
						</div>
						<div class="col-md-3"></div>
					</div>	<!-- end div of  total cart payment -->

					<div id="clientinfofill"> <!-- start information of client -->
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-3">
								<div class="form-group">
									<input id="clientname" class="form-control" type="text" name="clientname" placeholder="Enter Full Name" autofocus required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<input required size="5" type="text" value="+2507" readonly style="height: 30px;"><span><input style="height: 30px;" id="clientphone" type="telephone" name="clientphone" placeholder="Enter remain number" required>
									</span>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-3">
								<div class="form-group">
									<select id="mode" name="mode" class="form-control" required>
										<option>select mode</option>
										<option value="delivery">delivery</option>
										<option value="pickup">pickup</option>
									</select>
								</div>
							</div>
							<div class="col-md-5"></div>
						</div>
					</div> <!-- end of client information -->

					<div class="row payment" id="paying"> <!-- start pay type picture division -->
						<div class="col-md-2"></div>
						<div class="col-md-2">
						    <a id="cashlink" href="Javascript: void()">
						    	<img onclick="cashpay()" src="img/payment/cash.jpg" width="150px" height="100px">
						    </a>
						</div>
						<div class="col-md-2">
							<a id="mtnlink" href="Javascript: void()">
								<img onclick="mtnpay()" src="img/payment/mtn.png" width="150px" height="100px">
							</a>
						</div>
						<div class="col-md-2">
						    <a id="tigolink" href="Javascript: void()">
								<img onclick="tigopay()" src="img/payment/tigo.jpg" width="170px" height="100px">
							</a>
						</div>
						<div class="col-md-2">
							<a id="visalink" href="Javascript: void()">
						    	<img onclick="visapay()" src="img/payment/visa.gif" width="150px" height="100px">
							</a>
						</div>
						<div class="col-md-2"></div>
						
					</div> <!-- end pay type picture division -->

					<div id="cash" class="row pay">	<!-- start cash paytype division -->
						<div class="col-md-2"></div>
						<div class="col-md-4" style="background-image: url(img/payment/cash.jpg);
						 height: 260px; background-repeat: none; background-size: cover;">
						  	<table id="paymentwithdelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>Delivery fee</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td>
										  	<?php
											  	$paymentwithdelivery = $cartTotalM + 100;
											  	echo''.$paymentwithdelivery.' Frw';
										  	?>
										</td>
						  				<td>
						  					<?php
											  	$paymentwithdelivery = $cartTotal + 100;
											  	echo''.$paymentwithdelivery.' Frw';
										  	?>
						  				</td>
						  			</tr>
						  		</tbody>
						  	</table>
						  	<table id="paymentwithoutdelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  		</tbody>
						  	</table>
						</div>
						<div class="col-md-4 formpart" style="background-color: grey; height: 260px;">
							<div id="cashresponsepart">
								<div id="clientlocation" style="margin-top: 10px; display: none;">
									<div id="floorname" class="form-group">
										<select id="floor_name" name="floor_name" class="form-control" required>
											<option>select floor</option>
											<option value="floor -1">Floor -1</option>
											<option value="floor 0">Floor 0</option>
											<option value="floor 1">Floor 1</option>
											<option value="floor 2">Floor 2</option>
											<option value="floor 3">Floor 3</option>
											<option value="floor 4">Floor 4</option>
											<option value="floor 5">Floor 5</option>
											<option value="floor 6">Floor 6</option>
										</select>
									</div>
									<div id="officename" class="form-group">
										<input id="clientoffice" class="form-control" type="text" name="clientoffice" placeholder="Enter office" required>
									</div>
								</div>
								<div id="clientkind" class="form-group">
									<button type="button" class="btn btn-primary btn-md" onclick="member()"> Member</button> &nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" class="btn btn-info btn-md" onclick="nonmember()"> Non Member</button>
								</div>
								<div style="display: none;" id="emailmemberinfo">
									<p style="color: white;">Please enter email you use <br>to become a member.</p>
										<input class="form-control" type="email" id="memberemail" placeholder="enter your email" onkeyup="showmember()" onclick="showmember()">
										<br><br>
								</div>
								<input readonly style="display: none;" onclick="savemember()" id="confirmmember" value="confirm order" class="btn  btn-primary btn-md">

								<input readonly style="display: none;" onclick="savenotmember()" id="confirmnonmember" value="confirm order" class="btn  btn-info btn-md"><br>

								<button onclick="back()" style="margin-bottom: 0;" type="button" class="btn btn-danger btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Back </button>
								<br><br>	
							</div>
							<p id="loader"></p>
						</div>
						<div class="col-md-2"></div>
					</div>	<!-- end cash paytype division -->



					<div id="mtn" class="row pay">	<!-- start mtn paytype division -->
						<div class="col-md-2"></div>
						<div class="col-md-4" style="background-color: #ffbe00;
						 height: 250px; background-repeat: none; background-size: cover;">
						  	<table id="mtndelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>Delivery fee</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>MTN charges</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td>
										  	<?php
											  	$mtndelivery = $cartTotalM + 100 + 100;
											  	echo''.$mtndelivery.' Frw';
										  	?>
										</td>
						  				<td>
						  					<?php
											  	$mtnnondelivery = $cartTotal + 100 + 100;
											  	echo''.$mtnnondelivery.' Frw';
										  	?>
						  				</td>
						  			</tr>
						  		</tbody>
						  	</table>
						  	<table id="mtnwithoutdelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>MTN charges</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td><?php $mtntotalM = $cartTotalM + 100; echo''.$mtntotalM.' Frw' ?></td>
						  				<td><?php $mtntotal = $cartTotal + 100; echo''.$mtntotal.' Frw' ?></td>
						  			</tr>
						  		</tbody>
						  	</table>
							<button onclick="back()" style="margin-bottom: 0;" type="button" class="btn btn-danger btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Back </button>
						</div>
						<div class="col-md-4" style="background-color: #ffbe00; height: 250px;">
							<div id="mtnclientlocation" style="margin-top: 10px; display: none;">
								<div id="mtnfloorname" class="form-group">
									<select id="mtnfloor_name" name="mtnfloor_name" class="form-control">
										<option>select floor</option>
										<option value="floor -1">Floor -1</option>
										<option value="floor 0">Floor 0</option>
										<option value="floor 1">Floor 1</option>
										<option value="floor 2">Floor 2</option>
										<option value="floor 3">Floor 3</option>
										<option value="floor 4">Floor 4</option>
										<option value="floor 5">Floor 5</option>
										<option value="floor 6">Floor 6</option>
									</select>
								</div>
								<div id="mtnofficename" class="form-group">
									<input id="mtnclientoffice" class="form-control" type="text" name="mtnclientoffice" placeholder="Enter office" required>
								</div>
								<button onclick="back()" style="margin-bottom: 0;" type="button" class="btn btn-danger btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Back </button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button onclick="next()" type="button" class="btn btn-success btn btn-sm"><i class="glyphicon glyphicon-arrow-right"></i> Next </button>
							</div>
							<div id="mtnspecify" style="display: none;">
								<div id="mtnclientkind" class="form-group">
									<button type="button" class="btn btn-primary btn-md" onclick="mtnmember()"> Member</button> &nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" class="btn btn-info btn-md" onclick="mtnnonmember()"> Non Member</button>
								</div>
								<div style="display: none;" id="mtnemailmemberinfo">
									<form name="mtnformstatus" class="form">
										<div class="input-group">
										  <input type="text"  name="mtnmemberemail" onkeyup="mtnshowmember()" class="form-control" placeholder="enter an email you use to became a member">
										</div>
									</form>
									<div id="mtnmemberstatus"></div><br><br>
									<button onclick="next2()" type="button" class="btn btn-success btn btn-sm"><i class="glyphicon glyphicon-arrow-right"></i> Next </button>
								</div>
								<div id="lastconfirmmember" style="display: none;">
								  	<input required size="5" type="text" value="+25078" readonly><span><input type="telephone" name="phone" placeholder="Enter remain number"></span><br><br>
									<input readonly onclick="mtnsavemember()" id="mtnconfirmmember" value="confirm order" class="btn  btn-primary btn-md">
							  	</div>

								<input readonly style="display: none;" onclick="mtnsavenotmember()" id="mtnconfirmnonmember" value="confirm order" class="btn  btn-info btn-md">
							</div>
						</div>
						<div class="col-md-2"></div>
					</div>
					<!-- end mtn paytype division -->


					<div id="visa" class="row pay">	<!-- start visa paytype division -->
						<div class="col-md-2"></div>
						<div class="col-md-4" style="background-color: #EAF1FE;
						 height: 250px; background-repeat: none; background-size: cover;">
						  	<table id="visadelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>Delivery fee</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>VISA charges</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td>
										  	<?php
											  	$visadelivery = $cartTotalM + 100 + 100;
											  	echo''.$visadelivery.' Frw';
										  	?>
										</td>
						  				<td>
						  					<?php
											  	$visanondelivery = $cartTotal + 100 + 100;
											  	echo''.$visanondelivery.' Frw';
										  	?>
						  				</td>
						  			</tr>
						  		</tbody>
						  	</table>
						  	<table id="visawithoutdelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>VISA charges</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td><?php $visatotalM = $cartTotalM + 100; echo''.$visatotalM.' Frw' ?></td>
						  				<td><?php $visatotal = $cartTotal + 100; echo''.$visatotal.' Frw' ?></td>
						  			</tr>
						  		</tbody>
						  	</table>
						</div>
						<div class="col-md-4" style="background-color: #EAF1FE; height: 250px;">
							<input onclick="paybyvisa()" type="submit" name="confirm_button" value="confirm order" class="btn  btn-info btn-md">
							<button onclick="back()" style="margin-bottom: 0;" type="button" class="btn btn-danger btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Back </button>
						</div>
						<div class="col-md-2"></div>
					</div>	
					<!-- end visa paytype division -->

					<!-- start tigo paytype division -->
					<div id="tigo" class="row pay">	
						<div class="col-md-2"></div>
						<div class="col-md-4" style="background-color: #002e6e;
						 height: 250px; background-repeat: none; background-size: cover;">
						  	<table id="tigodelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>Delivery fee</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Tigo charges</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td>
										  	<?php
											  	$tigomdelivery = $cartTotalM + 100 + 100;
											  	echo''.$tigomdelivery.' Frw';
										  	?>
										</td>
						  				<td>
						  					<?php
											  	$tigonmdelivery = $cartTotal + 100 + 100;
											  	echo''.$tigonmdelivery.' Frw';
										  	?>
						  				</td>
						  			</tr>
						  		</tbody>
						  	</table>
						  	<table id="tigowithoutdelivery" class="table table-hovered" style="margin-top: 4px;">
						  		<thead>
							  		<tr>
								  		<th></th>
								  		<th>Member</th>
								  		<th>Non-member</th>
							  		</tr>
						  		</thead>
						  		<tbody>
						  			<tr>
						  				<td>cart payment</td>
						  				<td><?php echo''.$cartTotalM.' Frw' ?></td>
						  				<td><?php echo''.$cartTotal.' Frw' ?></td>
						  			</tr>
						  			<tr>
						  				<td>tigo charges</td>
						  				<td>100</td>
						  				<td>100</td>
						  			</tr>
						  			<tr>
						  				<td>Total Payment</td>
						  				<td><?php $tigototalM = $cartTotalM + 100; echo''.$tigototalM.' Frw' ?></td>
						  				<td><?php $tigototal = $cartTotal + 100; echo''.$tigototal.' Frw' ?></td>
						  			</tr>
						  		</tbody>
						  	</table>
						</div>
						<div class="col-md-4" style="background-color: #002e6e; height: 250px;">
							<br>
					        	<form class="form-inline" method="post" enctype="multipart/form-data" action="">
							  		<input required size="5" type="text" value="+25072" readonly><span><input type="telephone" name="phone" placeholder="Enter phone number"></span>
							  		<br><br>
					        		<input type="submit" name="confirm_button" value="confirm order" class="btn  btn-info btn-md">
						  	 	</form>
							<br><br>
							
							<br><br>
							<button onclick="back()" style="margin-bottom: 0;" type="button" class="btn btn-danger btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Back </button>
						</div>
						<div class="col-md-2"></div>
					</div>	<!-- end tigo paytype division -->


				</div>	<!-- container and infoDiv id end -->

			</div>	<!-- Checkout end -->

			<!-- including dynamic footer page -->
				<?php
					include 'footer.php';
				?>
			<!-- end of including footer page -->

		</div>	<!-- Inner Content end-->

	</div>	<!-- Page Wrapper -->	

	<span class="totop"><a href="#"><i class="fa fa-angle-up"></i></a></span>	<!-- Scroll to top -->

		<!-- Javascript files -->

		<!-- payment JS  -->
		<script type="text/javascript" src="js/payment.js"></script>
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
		<script src="js/jquery-3.2.0.js"></script>
		<!-- payrol js code -->
		<script src="js/payrol.js"></script>

		<script type="text/javascript">

			// start get member client info and send to processpage
		    function savemember(){
		        event.preventDefault();
		        var phone = $("#clientphone").val();
		        var name = $("#clientname").val();
		        var floor_name = $("#floor_name").val();
		        var office = $("#clientoffice").val();
		        var mode = $("#mode").val();
				var myVar;
		        var memberemail = $("#memberemail").val();
		        if (mode == 'delivery' && (floor_name == '' || floor_name == 'select floor')) {
		        	window.alert("please select floor where you found");
		           	return false;
		        }
		        else if (mode == 'delivery' && office == '') {
		        	window.alert("please fill an office where you found ");
		           	return false;
		        }
		        else if (memberemail == '') {
		        	window.alert("please enter email you use during registeration ");
		           	return false;
		        }
		        else {
		        	document.getElementById('loader').style.display = 'block';
		    		myVar = setTimeout(showPage, 3000);
					$.ajax({
						type : "GET",
						url : "process.php",
						dataType : "html",
						cache : "false",
						data : {
							name : name,
							phone : phone,
							office : office,
							floor_name : floor_name,
							mode : mode,
							memberemail : memberemail,
						},
						success : function(html, textStatus){
							$("#cashresponsepart").html(html);
						},
						error : function(xht, textStatus, errorThrown){
							alert("Error : " + errorThrown);
						}
					});
				}
			}
			// end get member client info and send to process page
			
			// start get non member client info and send to processpage
		    function savenotmember(){  	
				var myVar;
		        event.preventDefault();
		        var phone = $("#clientphone").val();
		        var name = $("#clientname").val();
		        var floor_name = $("#floor_name").val();
		        var office = $("#clientoffice").val();
		        var mode = $("#mode").val();
		        var myVar;
		        var clientkind = 'non member';
		        if (mode == 'delivery' && (floor_name == '' || floor_name == 'select floor')) {
		        	window.alert("please select floor where you found");
		           	return false;
		        }
		        else if (mode == 'delivery' && office == '') {
		        	window.alert("please fill an office where you found ");
		           	return false;
		        }
		        else if (clientkind == '') {
		        	window.alert("please choose your level (member or not) ");
		           	return false;
		        }
		        else{
		        	document.getElementById('loader').style.display = 'block';
			    	myVar = setTimeout(showPage, 3000);
					$.ajax({
						type : "GET",
						url : "process.php",
						dataType : "html",
						cache : "false",
						data : {
							name : name,
							phone : phone,
							office : office,
							floor_name : floor_name,
							mode : mode,
							clientkind : clientkind,
						},
						success : function(html, textStatus){
							$("#cashresponsepart").html(html);
						},
						error : function(xht, textStatus, errorThrown){
							alert("Error : " + errorThrown);
						}
					});
		    	}
			}
			// end get non member client info and send to process page

			function showPage() {
			  document.getElementById("loader").style.display = "none";
			  document.getElementById("response").style.display = "block";
			}
			// end of payment script
		</script>

		<script type="text/javascript">
			function mtnpay() {
			    event.preventDefault();
			    var phone = $("#clientphone").val();
			    var name = $("#clientname").val();
			    var mode = $("#mode").val();
			    if(phone == ''){
			       window.alert("please fill phone field");
			       return false;
			    }
			    else if (name == '') {
			    	window.alert("please fill Name field");
			       	return false;
			    }
			    else if (mode == '' || mode == 'select mode') {
			        window.alert("please select mode of paying and taking order. ");
			        return false;
			    }
			    else if (mode == 'pickup') {
			        document.getElementById('mtn').style.display = 'block';
			        document.getElementById('tigo').style.display = 'none';
			        document.getElementById('visa').style.display = 'none';
			        document.getElementById('cash').style.display = 'none';
			        document.getElementById('paying').style.display = 'none';
			        document.getElementById('clientinfofill').style.display = 'none';
			        document.getElementById('mtnclientlocation').style.display = 'none';
			        document.getElementById('mtndelivery').style.display = 'none';
			        document.getElementById('mtnwithoutdelivery').style.display = 'block';
					document.getElementById('mtnspecify').style.display = 'none';
			    }
			    else{
					document.getElementById('mtn').style.display = 'block';
					document.getElementById('tigo').style.display = 'none';
					document.getElementById('visa').style.display = 'none';
					document.getElementById('cash').style.display = 'none';
					document.getElementById('paying').style.display = 'none';
					document.getElementById('clientinfofill').style.display = 'none';
			        document.getElementById('mtnclientlocation').style.display = 'block';
			        document.getElementById('mtnwithoutdelivery').style.display = 'none';
			        document.getElementById('mtndelivery').style.display = 'block';
					document.getElementById('mtnspecify').style.display = 'none';
				}
			}
		</script>

		<script type="text/javascript">
			function next() {
		        event.preventDefault();
		        var mtnfloor_name = $("#mtnfloor_name").val();
		        var mtnoffice = $("#mtnclientoffice").val();
		        var mode = $("#mode").val();
		        if (mode == 'delivery' && (mtnfloor_name == '' || mtnfloor_name == 'select floor')) {
		        	window.alert("please select floor where you found");
		           	return false;
		        }
		        else if (mode == 'delivery' && mtnoffice == '') {
		        	window.alert("please fill an office where you found ");
		           	return false;
		        }
		        else {
		        	document.getElementById('mtnclientlocation').style.display = 'none';
					document.getElementById('mtnspecify').style.display = 'block';
		        }
			}
		</script>
		<script type="text/javascript">
			function next2() {
		        event.preventDefault();
		        var mtnmemberemail = $("#mtnmemberemail").val();
		        if (mtnmemberemail == '') {
		        	window.alert("please enter email you use when become a member");
		           	return false;
		        }
		        else {
					document.getElementById('mtnspecify').style.display = 'none';
		        	document.getElementById('lastconfirmmember').style.display = 'block';
		        }
			}
		</script>

		<script type="text/javascript">
			function mtnshowmember() {
				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET","memberstatus.php?email="+document.mtnformstatus.mtnmemberemail.value,false);
				xmlhttp.send(null);
				document.getElementById('mtnmemberstatus').innerHTML=xmlhttp.responseText;
			}
		</script>

		<script type="text/javascript">
			function mtnmember() {
			    var floorname = $("#floor_name").val();
			    var officename = $("#clientoffice").val();
			    var mode = $("#mode").val();
				document.getElementById('mtnemailmemberinfo').style.display = 'block';
			}
		</script>

</body>
</html>