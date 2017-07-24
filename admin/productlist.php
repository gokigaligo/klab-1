<?php
    include ("../db.php");
    $sms = "";
    $product_name = "";
    $confirm_delete = '';
    if (isset($_POST['product_name'])) {
            $product_name = $_POST['product_name'];
            $category = $_POST['category'];
            $member_price = $_POST['member_price'];
            $non_member_price = $_POST['non_member_price'];
            $product_pic = $_FILES['product_pic']['name'];
            $target_dir = "../img/pro/";
            $target_file = $target_dir . basename($_FILES["product_pic"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["product_pic"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    //echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["product_pic"]["size"] > 150000) {
               // echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["product_pic"]["tmp_name"], $target_file)) {
                    //echo "The file ". basename( $_FILES["product_pic"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            $sqlselect = $con ->query("SELECT * FROM products WHERE Name = '$product_name' AND price_non_member = '$non_member_price'");
            $count = mysqli_num_rows($sqlselect);
            if ($count > 0) {
                $sms.='<p style="color: red;">'.$product_name.' already exit in database. try to add another</p>';
            }
            else{
            $sqlInsert = $con ->query("INSERT INTO products(Name,category,price_member,price_non_member,pic) VALUES('$product_name', '$category', '$member_price', '$non_member_price', '$product_pic')");
            $sms.= '<p style="color: green;">'.$product_name.' successfully added to your product</p>';
            }
     }

    if (isset($_GET['delete'])) {
        $fetch_name_of_pro = $con ->query("SELECT *FROM products WHERE id = '".$_GET['delete']."'");
        $rowname = mysqli_fetch_array($fetch_name_of_pro);
        $name = $rowname['Name'];
        $sqlDelete = $con ->query("DELETE FROM products WHERE id='".$_GET['delete']."'");
        $confirm_delete .= '<p style="color: green; text-align: center;">'.$name.' Has been deleted from your product</p>';
        // if ($sqlDelete) {
        //     unlink("../img/".$_GET['pic']); 
        //     } 
    }

?>


<?php
if (isset($_GET['status'])) {
    $status =  $_GET['status'];
    $change = $_GET['change'];
    include 'db.php';
    if($status == 'Inactive')
    {
        $sql = $con ->query("UPDATE `products` SET `status` = 'Active' WHERE id='$change'");
        ?>
        <script type="text/javascript">
            window.location.href = "productlist";
        </script>
        <?php
    }
    else
    {
        $sql = $con ->query("UPDATE `products` SET `status` = 'Inactive' WHERE id='$change'");
        ?>
        <script type="text/javascript">
            window.location.href = "productlist";
        </script>
        <?php
    }
    exit();
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
					
					<li class="active">
						<a href="javascript: void()">
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
			<h1 class="page-header">Product List</h1>
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
                            <h4 class="panel-title">Product Table - List</h4>
                        </div>
                        <div class="panel-body">
                            <!-- Button trigger modal -->
                            <button class="btn btn-inverse btn-md" data-toggle="modal" data-target="#modal-message">
                                ADD <span  class="fa fa-plus"></span>
                            </button>
                            <hr>
                            <!-- Modal -->
                            <div class="modal modal-message fade" id="modal-message" tabindex="0" role="dialog" aria-labelledb.phpy="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">ADD</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-hover table table-condensed table  table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="180px">Product Name</th>
                                                                <th>Price Member</th>
                                                                <th>Price Non Member</th>
                                                                <th width="120px;">Category</th>
                                                                <th>Product Picture</th>
                                                                <th width="100px;">Operation</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <form action="productlist" method="post" enctype="multipart/form-data">
                                                                <td><input placeholder="product name" type="text" name="product_name" class="form-control" required></td>
                                                                <td><input placeholder="price member" type="number" name="member_price" class="form-control" required></td>
                                                                <td><input placeholder="price non member" type="number" name="non_member_price" class="form-control" required></td>
                                                                <td>
                                                                <select name="category" class="form-control">
                                                                    <option value="fanta">fanta</option>
                                                                    <option value="tea">tea</option>
                                                                    <option value="coffee">coffee</option>
                                                                    <option value="snacks">snacks</option>
                                                                    <option value="others">others</option>
                                                                </select></td>
                                                                <td><input type="file" name="product_pic" class="form-control" required></td>
                                                                <td class="actions">
                                                                    <button type="submit" class="btn btn-success  btn btn-custom waves-effect btn btn-xs"><i class="fa fa-save success"></i>
                                                                    </button>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <button type="reset" class="btn btn-primary  btn btn-custom waves-effect btn btn-xs"><i class="fa fa-times"></i>
                                                                    </button>
                                                                </td>
                                                            </form>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                        if (isset($_POST['product_name'])) {
                                                           $product_name =  $_POST['product_name'];
                                                        }

                                                        echo $sms;
                                                    ?>
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
                            <!-- /.modal -->
                            <?php
                                if (isset($_POST['product_name'])) {
                                   $product_name =  $_POST['product_name'];
                                }
                                echo $confirm_delete;
                                echo $sms;
                            ?>
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>member Price</th>
                                        <th>non member Price</th> 
                                        <th>Category</th>
                                        <th>picture</th>
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include("../db.php");
                                        $sqlFetchProduct = $con ->query("SELECT * FROM products ORDER BY id DESC");
                                        $n = 0;
                                        while ($row = mysqli_fetch_array($sqlFetchProduct)) {
                                            $n++;
                                            $productId = $row['id'];
                                            echo '<tr class="odd gradeX">
                                                <td>'.$n.'</td>
                                                <td>'.$row['Name'].'</td>
                                                <td>'.number_format($row['price_member']).'</td>
                                                <td>'.number_format($row['price_non_member']).'</td>
                                                <td>'.$row['category'].'</td>
                                                <td><a href="editpropic?pic='.$row['id'].'"><img class="img-responsive" src="../img/pro/'.$row['pic'].'" width="80px" height="40px"></a></td>
                                                <td class="actions">
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="editproduct?edit='.$row['id'].'"><i class="fa fa-pencil text-primary"></i></a>
                                        
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="?delete='.$row['id'].'& pic='.$row['pic'].'"><i class="fa fa-trash-o text-danger"></i></a>';
                                                

                                                if($row['status'] == 'Active')
                                                {
                                                    echo '
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="?change='.$row['id'].'& status='.$row['status'].'"><i class="glyphicon glyphicon-ok-circle text-success"></i></a>';
                                                }
                                                else
                                                {
                                                    echo '
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="?change='.$row['id'].'& status='.$row['status'].'"><i class="glyphicon glyphicon-ban-circle text-danger"></i></a>';
                                                }
                                            echo'</td></tr>';
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53034621-1', 'auto');
  ga('send', 'pageview');

</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/table_manage by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Apr 2017 15:21:17 GMT -->
</html>
