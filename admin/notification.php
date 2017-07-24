 <?php
	session_start();
	$userId ='';
	include '../db.php';
	if (isset($_SESSION['klabusername'])) {
	    $name = $_SESSION['klabusername'];
	    $password = $_SESSION['klabpassword'];
	    $selectid = $con ->query("SELECT * FROM users WHERE name='$name' AND password='$password'");
	    $fetchid = mysqli_fetch_array($selectid);
	    $userId = $fetchid['id'];
	}
	elseif (!isset($_SESSION['klabusername'])) {
	    header("location: login");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="shortcut icon" type="image/png" href="../img/favicon.png">
	<title>kLab Coffee Bar | Admin</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="assets/css/animate.min.css" rel="stylesheet" />
	<link href="assets/css/style.min.css" rel="stylesheet" />
	<link href="assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body onload="updatenoti()">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="index" class="navbar-brand"><span><img src="../img/favicon.png" height="30" width="30"></span> kLab Coffee Bar</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->

				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<li>
						<form class="navbar-form full-width">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter keyword" />
								<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</li>
					<li class="dropdown">
						<a id="notif" href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
							<i id="notif" class="fa fa-bell-o"></i>
							<span id="notification_number" class="label">	
							</span>
                            <input type="hidden" id="noti" value="1">
						</a>
						<ul id="notificationdrop" class="dropdown-menu media-list pull-right animated fadeInDown">
						</ul>
					</li>
					<li class="dropdown navbar-user">
                        <?php
                            include("../db.php");
                            $sql = $con ->query("SELECT * FROM users WHERE name = '".$_SESSION['klabusername']."'");
                            while ($row = mysqli_fetch_array($sql)) {
                                echo'
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="../img/user/'.$row['profile'].'" alt="'.$row['name'].'" >
										<span class="hidden-xs">'.$row['name'].'</span> <b class="caret"></b>
									</a>
									<ul class="dropdown-menu animated fadeInLeft">
										<li class="arrow"></li>
										<li><a href="edituserpic?editprofile='.$row['id'].'">Edit Profile</a></li>
										<li><a href="chooseuser?userId='.$row['id'].'">Setting</a></li>
										<li class="divider"></li>
										<li><a href="logout">Log Out</a></li>
									</ul>
                                ';
                            }
                        ?>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		

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

		<script type="text/javascript">
			function disnum() {
				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET","notification_number.php",false);
				xmlhttp.send(null);
				document.getElementById('notification_number').innerHTML=xmlhttp.responseText;
			}
			disnum();
			setInterval(function() {
				disnum();
			}, 3000)
		</script>

		<script type="text/javascript">
			function disdrop() {
				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET","notificationdrop.php",false);
				xmlhttp.send(null);
				document.getElementById('notificationdrop').innerHTML=xmlhttp.responseText;
			}
			disdrop();
			setInterval(function() {
				disdrop();
			}, 3000)
		</script>

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
                                        <a href="javascript:;"><img src="../img/user/'.$row['profile'].'" alt="" /></a>
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
					<li class="has-sub">
						<a href="index">
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
					<li class="active">
						<a href="javascript: void()">
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
		<div id="content" class="content content-full-width">
		    <!-- begin vertical-box -->
		    <div class="vertical-box">
		        <!-- begin vertical-box-column -->
		        <div class="vertical-box-column width-250">
		            <!-- begin wrapper -->
                    <div class="wrapper bg-silver text-center">
                        <button id="notif" href="javascript: void();" class="btn btn-success p-l-40 p-r-40 btn-sm">
                            Notification
                            <input type="hidden" id="noti" value="1">
                        </button>
                    </div>
		            <!-- end wrapper -->

		            <!-- begin wrapper -->
                    <div class="wrapper">
                        <p><b>FOLDERS</b></p>
                        <ul class="nav nav-pills nav-stacked nav-sm">
                            <li class="active">
                            	<a href="javascript: void();"><i class="fa fa-comment fa-fw m-r-5"></i> Comment <span class="badge pull-right">
								<?php
                                    include("../db.php");
                                    $sqlselect = $con ->query("SELECT * FROM notification WHERE noti_type = 'comment'");
                                    $sqlcount = mysqli_num_rows($sqlselect);
                                    echo number_format($sqlcount);
                                ?>	</span></a>
                           	</li>
                            <li class="active">
                            	<a href="javascript: void();"><i class="fa fa-shopping-cart fa-fw m-r-5"></i> Order <span class="badge pull-right">
                                <?php
                                    include("../db.php");
                                    $sqlFetchOrder = $con ->query("SELECT * FROM orders");
                                    $numOfOrdered = mysqli_num_rows($sqlFetchOrder);
                                    echo number_format($numOfOrdered);
                                ?> </span></a>
                           	</li>
                        </ul>
                    </div>
		            <!-- end wrapper -->
		            
		        </div>
		        <!-- end vertical-box-column -->
		        <!-- begin vertical-box-column -->
		        <div class="vertical-box-column">
		            <!-- begin wrapper -->
                    <div class="wrapper bg-silver-lighter">
                        <!-- begin btn-toolbar -->
                        <div class="btn-toolbar">
                            <!-- begin btn-group -->
                            <div class="btn-group">
                                <button class="btn btn-sm btn-white" data-toggle="tooltip" data-placement="top" data-title="Refresh" data-original-title="" title=""><i class="fa fa-refresh"></i></button>
                            </div>
                            <!-- end btn-group -->
                        </div>
                        <!-- end btn-toolbar -->
                    </div>
		            <!-- end wrapper -->

		            <!-- begin list-notification -->
                    <ul class="list-group list-group-lg no-radius list-email">
						<?php
                            include("../db.php");
                            $sqlFetchOrder = $con ->query("SELECT * FROM orders");
                            $numOfOrdered = mysqli_num_rows($sqlFetchOrder);
                            $sqlselectcomment = $con->query("SELECT * FROM notification WHERE noti_type = 'comment'");
                            $sqlcount = mysqli_num_rows($sqlselectcomment);
                            $notification = $con->query("SELECT * FROM notification ORDER BY id DESC");
                            while ($rownoti = mysqli_fetch_array($notification)) {
                            	if ($rownoti['noti_type'] == 'comment') {
                            		echo '
	                            		<div>
					                        <li id="'.$rownoti['id'].'" class="list-group-item primary">
					                            <a href="javascript: void();" class="email-user">
					                                <i class="fa fa-comment"></i>
					                            </a>
					                            <div class="email-info">
					                                <span class="email-time">
					                                    '.$rownoti['noti_time'].'
					                                </span>
					                                <h5 class="email-title">
					                                    <a href="javascript: void();">'.$rownoti['noti_from'].'</a>
					                                </h5>
					                                <p class="email-desc">'.$rownoti['content'].'
					                                </p>
					                            </div>
					                        </li>
				                        </div>
                            		';
                            	}
                            	elseif ($rownoti['noti_type'] == 'order') {
                            		echo '
	                            		<div>
					                        <li id="'.$rownoti['id'].'" class="list-group-item primary">
					                            <a href="javascript: void();" class="email-user">
					                                <i class="fa fa-shopping-cart"></i>
					                            </a>
					                            <div class="email-info">
					                                <span class="email-time">
					                                    '.$rownoti['noti_time'].'
					                                </span>
					                                <h5 class="email-title">
					                                    <a href="javascript: void();">'.$rownoti['noti_from'].'</a>
					                                </h5>
					                                <p class="email-desc">'.$rownoti['content'].'
					                                </p>
					                            </div>
					                        </li>
				                        </div>
                            		';
                            	}
                            	else{
                            		echo '
				                        <li id="'.$rownoti['id'].'" class="list-group-item primary">
				                            <a href="javascript: void();" class="email-user">
				                                <i class="fa fa-warning"></i>
				                            </a>
				                            <div class="email-info">
				                                <span class="email-time">
				                                    '.$rownoti['noti_time'].'
				                                </span>
				                                <h5 class="email-title">
				                                    <a href="javascript: void();">'.$rownoti['noti_from'].'</a>
				                                </h5>
				                                <p class="email-desc">'.$rownoti['content'].'
				                                </p>
				                            </div>
				                        </li>
                            		';
                            	}
                            }
                        ?> 
                    </ul>
		            <!-- end list-email -->
		            <!-- begin wrapper -->
                    <div class="wrapper bg-silver-lighter clearfix">
                        <div class="m-t-5">
                        	<?php
                            include("../db.php");
	                            $sqlFetchOrder = $con ->query("SELECT * FROM orders");
	                            $numOfOrdered = mysqli_num_rows($sqlFetchOrder);
	                            $sqlselectcomment = $con->query("SELECT * FROM notification WHERE noti_type = 'comment'");
	                            $sqlcountcomment = mysqli_num_rows($sqlselectcomment);
	                            echo ''.number_format($sqlcountcomment).' Comment, and '.number_format($numOfOrdered).' Orders';
                        	?>
                        </div>
                    </div>
		            <!-- end wrapper -->
		        </div>
		        <!-- end vertical-box-column -->
		    </div>
		    <!-- end vertical-box -->
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
	<script src="assets/js/email-inbox-v2.demo.min.js"></script>
	<script src="assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script>
		$(document).ready(function() {
			App.init();
			InboxV2.init();
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
