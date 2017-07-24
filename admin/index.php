<?php 
	include("topheader.php"); 
?>
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
                        <?php
                            include("../db.php");
                            $sql = $con ->query("SELECT * FROM users WHERE name = '".$_SESSION['klabusername']."'");
                            while ($row = mysqli_fetch_array($sql)) {
			                    echo'
									<div class="image">
										<a href="javascript:;">
                                            <img src="../img/user/'.$row['profile'].'" alt="'.$row['name'].'" >
                                        </a>
									</div>
									<div class="info">
										'.$row['name'].'
										<small>'.$row['category'].'</small>
									</div>
								';
                            }
                        ?>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="active">
						<a href="javascript: void()">
						    <i class="fa fa-laptop"></i>
						    <span>Dashboard</span>
					    </a>
					</li>
					
					<li class="has-sub">
						<a href="productlist">
						    <i class="fa fa-list"></i>
						    <span>products</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="orderview">
						    <i class="fa fa-shopping-cart"></i>
						    <span>Order</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="member">
						    <i class="fa fa-users"></i>
						    <span>Member</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="comment">
						    <i class="fa fa-comment"></i>
						    <span>Comment</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="notification">
						    <i class="fa fa-bell-o"></i>
						    <span>Notification</span>
						</a>
					</li>
					
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header">kLab Coffee Bar</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-green">
						<div class="stats-icon"><i class="fa fa-comment"></i></div>
						<div class="stats-info">
							<h4>TOTAL COMMENT</h4>
							<p>
								<?php
                                    include("../db.php");
                                    $sqlselect = $con ->query("SELECT * FROM notification WHERE noti_type = 'comment'");
                                    $sqlcount = mysqli_num_rows($sqlselect);
                                    echo number_format($sqlcount);
                                ?>	
                            </p>	
						</div>
						<div class="stats-link">
							<a href="comment">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fa fa-shopping-cart"></i></div>
						<div class="stats-info">
							<h4>TOTAL ORDER</h4>
							<p>
                                <?php
                                    include("../db.php");
                                    $sqlFetchOrder = $con ->query("SELECT * FROM orders");
                                    $numOfOrdered = mysqli_num_rows($sqlFetchOrder);
                                    echo number_format($numOfOrdered);
                                ?>   
							</p>	
						</div>
						<div class="stats-link">
							<a href="orderview">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-purple">
						<div class="stats-icon"><i class="fa fa-users"></i></div>
						<div class="stats-info">
							<h4>TOTAL MEMBER</h4>
							<p>
                                <?php
                                    $sqlselect = $con ->query("SELECT * FROM member");
                                    $sqlcount = mysqli_num_rows($sqlselect);
                                    echo number_format($sqlcount);
                                ?>
                            </p>	
						</div>
						<div class="stats-link">
							<a href="member">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fa fa-list"></i></div>
						<div class="stats-info">
							<h4>TOTAL PRODUCTS</h4>
							<p>
                                <?php
                                    include ("../db.php");
                                    $sqlFetchPro = $con ->query("SELECT * FROM products");
                                    $productNum = mysqli_num_rows($sqlFetchPro);
                                    echo number_format($productNum);
                                ?>
							</p>	
						</div>
						<div class="stats-link">
							<a href="productlist">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
			</div>
			<!-- end row -->
			<!-- begin row -->
			<div class="row">
				<!-- begin col-8 -->
				<div class="col-md-8">
					<div class="panel panel-inverse" data-sortable-id="index-1">
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
							</div>
							<h4 class="panel-title">Website Analytics (Last 7 Days)</h4>
						</div>
						<div class="panel-body">
							<div id="interactive-chart" class="height-sm"></div>
						</div>
					</div>
				</div>
				<!-- end col-8 -->
				<!-- begin col-4 -->
				<div class="col-md-4">
					<div class="panel panel-inverse" data-sortable-id="index-6">
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							</div>
							<h4 class="panel-title">Notification Panel</h4>
						</div>
						<div class="panel-body p-t-0 ">
							<ul class="list-group list-group-lg no-radius list-email" id="notification_panel">
							</ul>
							<ul type="none">
	                            <li class="dropdown-footer text-center">
	                                <a href="notification">View more</a>
	                            </li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
		</div>
		<!-- end #content -->

		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="assets/crossbrowserjs/html5shiv.js"></script>
		<script src="assets/crossbrowserjs/respond.min.js"></script>
		<script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="assets/plugins/flot/jquery.flot.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.time.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="assets/plugins/sparkline/jquery.sparkline.js"></script>
	<script src="assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
	<script src="assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="assets/js/dashboard.min.js"></script>
	<script src="assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script type="text/javascript">
		function dis() {
			xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","notification_panel.php",false);
			xmlhttp.send(null);
			document.getElementById('notification_panel').innerHTML=xmlhttp.responseText;
		}
		dis();
		setInterval(function() {
			dis();
		}, 3000)
	</script>

	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-53034621-1', 'auto');
	  ga('send', 'pageview');

	</script>
	<script type="text/javascript"> 
	  $(document).ready(function() {
	    $("#notif").click(function() {
     		var a = $("#noti").val();
			$.ajax ({
			url: "updatenoti.php",
			type: "POST",
			async: false,
			data: {
			  "a" : a
			},
			success: function(data) {
			}
			})
	    });
	  });
	</script>
</body>
</html>
