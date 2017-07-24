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
<body>
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
