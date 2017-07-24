        <?php
        $sms = '';
        	include '../db.php';
		    if (isset($_GET['delete'])) {
		        $sqlDelete = $con ->query("DELETE FROM notification WHERE id='".$_GET['delete']."'");
		        $sms.='<p style="color: green; text-align: center; font-weight: bold;">Sms deleted Successfully!</p>';
		    }  
		?>

        <?php include("topheader.php"); ?>
		
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
					<li class="active">
						<a href="javascript: void()">
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
			<h1 class="page-header">Comment List</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            </div>
                            <h4 class="panel-title">Comment Table - List</h4>
                        </div>
                        <?php echo $sms; ?>
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="25%">Comment From</th>
                                        <th width="55%">Comment Content</th>
                                        <th width="17%">Time</th>
                                        <th width="3%">delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include("../db.php");
                                        $sqlFetchcomment = $con ->query("SELECT * FROM  notification WHERE noti_type = 'comment' ORDER BY id DESC");
                                        $n = 1;
                                         while ($row = mysqli_fetch_array($sqlFetchcomment)) {
                                            $comment_id = $row['id'];
                                            echo '
                                                <tr>
                                                    <td>'.$n.'</td>
                                                    <td>'.$row['noti_from'].'</td>
                                                    <td>'.$row['content'].'</td>
                                                    <td>'.$row['noti_time'].'</td>
                                                    <td><a href="?delete='.$row['id'].'"><i class="fa fa-trash-o text-danger"</i></a></td>
                                                </tr>
                                            ';
                                            $n++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
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
	<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
	<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="assets/js/table-manage-default.demo.min.js"></script>
	<script src="assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			TableManageDefault.init();
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

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/table_manage by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Apr 2017 15:21:17 GMT -->
</html>
