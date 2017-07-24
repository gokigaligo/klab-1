        <?php include("topheader.php"); ?>
        <style type="text/css">
        	#Receive {
        		background-color: blue;
        	}
        	#Reject {
        		background-color: red;
        	}
        	#delivered {
        		background-color: green;
        	}
        	#ordered {
        		background-color: lightblue;
        	}
        </style>
		
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
					<li class="active">
						<a href="javascript: void()">
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
			<h1 class="page-header">Order List</h1>
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
                            <h4 class="panel-title">Order Table - List</h4>
                        </div>
                        <div class="panel-body" id="table">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="20%"> Full Client info</th>
                                        <th>Floor</th>
                                        <th>Company</th>
                                        <th>Order view show</th> 
                                        <th>Driving mode</th>
                                        <th width="12%">order time</th>
                                        <th>payment type</th>
                                        <th>Total payment</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include("../db.php");
                                        $sqlFetchorder = $con ->query("SELECT orders.conf_id AS conf_id,kind,bg,pay_type,customer_name,product_id_qty,customer_phone,floor_name,office,totalpay,get_way,ordered_time,status FROM orders JOIN customers  WHERE orders.conf_id=customers.conf_id ORDER BY orders.id DESC");
                                            $n=0;
                                         while ($row = mysqli_fetch_array($sqlFetchorder)) {
                                            $n++;
                                            echo '
                                                <tr class="odd gradeX '.$row['bg'].'">
                                                    <td>'.$n.'</td>
                                                    <td><b>Name:</b> '.$row['customer_name'].'<br>
                                                    	<b>Phone:</b> '.$row['customer_phone'].'<br>
                                                    	<b>kind:</b> '.$row['kind'].'
                                                    </td>
                                                    <td>'.$row['floor_name'].'</td>
                                                    <td>'.$row['office'].'</td>
                                                    <td>'.$row['product_id_qty'].'</td>
                                                    <td>on '.$row['get_way'].'</td>
                                                    <td>'.$row['ordered_time'].'</td>
                                                    <td>'.$row['pay_type'].'</td>
                                                    <td>'.$row['totalpay'].' Frw</td>
                                                    <td>'.$row['status'].'
                                                    <br><a href="javascript: void();" onclick="edit(orderid='.$row['conf_id'].')" id="edit">Edit</a></td>
                                                </tr>
                                            ';
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

    <!-- Modal -->
    <div class="modal modal-message fade" id="Edit" tabindex="0" role="dialog" aria-labelledb.phpy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Edit Order Status</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                        	<form method="post" enctype="multipart/form-data">
                        		<select name="status" class="form-control">
                        			<?php echo $row['status'];?>
                        			<option>Accept</option>
                        			<option>Load</option>
                        			<option>Loaded</option>
                        		</select>
                        	</form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
	
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
	<script type="text/javascript"> 
		function edit(orderid){
			var orderid = orderid;
			$.ajax({
					type : "GET",
					url : "editstatus.php",
					dataType : "html",
					cache : "false",
					data : {
						
						orderid : orderid,
					},
					success : function(html, textStatus){
						$("#table").html(html);
					},
					error : function(xht, textStatus, errorThrown){
						alert("Error : " + errorThrown);
					}
			});
		}
	</script>
</body>
</html>
