
<?php include 'dy_cart.php'; ?>
	<body data-spy="scroll" data-target=".navbar" data-offset="50">
		<div class="header">
			<div class="container">
				<!-- Header top area content -->
				<div class="header-top">
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<!-- Header top left content contact -->
							<div class="header-contact">
								<!-- Contact number -->
								<a href="all#category">
									<i style="font-size: 55px;" class="fa fa-shopping-cart red"></i>
									<span style="font-size: 15px;">
										Order Online Food and Beverages<br>at KCafe
									</span>
								</a>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
						</div>
						<div class="col-md-4 col-sm-4">
							<!-- Button Kart -->
							<div class="btn-cart-md">
								<a class="cart-link" href="javascript:void()" data-toggle="collapse" data-target="#cart">
									<!-- Image -->
									<img class="img-responsive" src="img/cart.png" alt="" />
									<!-- Heading -->
									<h4>Order Cart</h4>
									<?php
										if (!isset($_SESSION['cart_array']) || $_SESSION['cart_array'] == '') {
											$i = 0;
											$cartTotal = 0;
											echo '<span>'.$i.' Product</span>';
										}
										else{
											$i=0;
											foreach ($_SESSION['cart_array'] as $each_item) {
												$i++;
											}
											echo '<span>'.$i.' Product(s)</span>';
											} 
									?>

									<?php
										if (!isset($_SESSION['cart_array']) || $_SESSION['cart_array'] == '') {
											echo '
												<ul id="cart" class="cart-dropdown" role="menu">
													your cart is empty!
												</ul>
											';
										}
										else{
											foreach ($_SESSION['cart_array'] as $each_item) {
												$item_id = $each_item['item_id'];
												include("db.php");
												$sql = $con ->query("SELECT * FROM products WHERE id = '$item_id' LIMIT 1");
												while ($row = mysqli_fetch_array($sql)) {
													$ItemName = $row['Name'];
													$ItemId = $row['id'];
													$ItemMPrice = $row['price_member'];
													$ItemNMPrice = $row['price_non_member'];
													$itemPic = $row['pic'];
													//$details = $row['details'];
												}
											}
											echo '
												<ul id="cart" class="cart-dropdown" role="menu">
													<li>
														<!-- Cart items for shopping list -->
														<div class="cart-item">
															<!-- Item remove icon -->
															<a href="#"><i class="fa fa-times"></i></a>
															<!-- Image -->
															<img class="img-responsive img-rounded" src="img/pro/'.$itemPic.'" alt="'.$ItemName.'" />
															<!-- Title for purchase item -->
															<span class="cart-title"><a href="#">'.$ItemName.'</a></span>
															<!-- Cart item price -->
															<span class="cart-price pull-right red">'.$ItemNMPrice.' Frw/-</span>
															<div class="clearfix"></div>
														</div>
													</li>
													<li>
														<!-- Cart items for shopping list -->
														<div class="">
															<center>
															<a class="btn btn-info" href="cart">See Cart</a>
															<a class="btn btn-success" href="payrol">Checkout</a>
															</center>
														</div>
													</li>
												</ul>
											';
										}
									?>
									<div class="clearfix"></div>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-9 col-sm-8">
							<!-- Navigation -->
							<nav class="navbar navbar-default navbar-right" role="navigation">
								<div class="container-fluid">
									<!-- Brand and toggle get grouped for better mobile display -->
									<div class="navbar-header">
										<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
											<span class="sr-only">Toggle navigation</span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
										</button>
									</div>

									<!-- Collect the nav links, forms, and other content for toggling -->
									<div class="collapse navbar-collapse" id="navbar">
										<ul class="nav navbar-nav">
											<li><a href="all#category"><img src="img/kLab_stamp.jpg" class="img-responsive" alt="" /> All</a></li>
											<li><a href="fanta#category"><img src="img/nav-menu/nav11.jpg" class="img-responsive" alt="" /> Fanta</a></li>
											<li><a href="coffee#category"><img src="img/nav-menu/nav2.jpg" class="img-responsive" alt="" /> Coffee</a></li>
											<li><a href="tea#category"><img src="img/nav-menu/nav3.jpg" class="img-responsive" alt="" /> Tea</a></li>
											<li><a href="snacks#category"><img src="img/nav-menu/nav4.jpg" class="img-responsive" alt="" /> Snacks</a></li>
											<li><a href="softdrink#category"><img src="img/nav-menu/softdrink.jpg" class="img-responsive" alt="" /> Soft Drink</a></li>
										</ul>
									</div><!-- /.navbar-collapse -->
								</div><!-- /.container-fluid -->
							</nav>
						</div>
						<div class="col-md-2 col-sm-3">
							<form name="formsearch" style="margin-top: 40px;" class="form">
								<div class="input-group">
								  <input type="text"  name="topsearch" onkeyup="auto_search()" class="form-control" placeholder="Search Product here...">
								</div>
							</form>
							<div id="getdata"></div>
						</div>
					</div>
				</div>
			</div> <!-- / .container -->
		</div>
		<!-- auto search  -->
		<script src="js/auto.js"></script>
		
		