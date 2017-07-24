
<?php
    require('../db.php');
    $productname = "";
    $profile = "";
    $editid = "";
    if (isset($_GET['editprofile'])) {
        $editprofile = $_GET['editprofile'];
    }
    else{
?>
    <script type="text/javascript">
        window.location.href = 'index';
    </script>
<?php
    }
?> 
<?php
    if (isset($_FILES['editprofile'])) {
        $profile = $_FILES['editprofile']['name'];
        $target_dir = "../img/user/";
        $target_file = $target_dir . basename($_FILES["editprofile"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["editprofile"]["tmp_name"]);
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
        if ($_FILES["editprofile"]["size"] > 1500000) {
            //echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["editprofile"]["tmp_name"], $target_file)) {
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $update="UPDATE users set profile='".$profile."' WHERE id='".$editprofile."'";
        mysqli_query($con, $update) or die(mysqli_error());
        echo '<p style="color: green;">Updated succeessfully!!</p>';
    ?>
        <script type="text/javascript">
            window.location.href = 'index';
        </script>
    <?php
    }
?>

<?php 
    if (isset($_GET['editprofile'])) {
        $editprofile=$_GET['editprofile'];
        include '../db.php';
        $query = $con ->query("SELECT * FROM users WHERE id='$editprofile'"); 
        while ($row = mysqli_fetch_array($query)) {
            $username = $row['name'];
            $profile = $row['profile'];
        }
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
                            while ($row1 = mysqli_fetch_array($sql)) {
                                echo'
                                    <div class="image">
                                        <a href="javascript:;">
                                            <img src="../img/user/'.$row1['profile'].'" alt="'.$row1['name'].'" >
                                        </a>
                                    </div>
                                    <div class="info">
                                        '.$row1['name'].'
                                        <small>'.$row1['category'].'</small>
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
            <h1 class="page-header">Edit  - <?php echo'Picture of '.$username.''; ?></h1>
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
                            <h4 class="panel-title">Edit  - <?php echo'Picture of '.$username.''; ?></h4>
                        </div>
                        <div class="panel-body">
                            <form name="form" method="post" action="" enctype="multipart/form-data">
                                <div class="table table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>New Picture</th>
                                                <th>Save</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>01</td>
                                                <td><input type="text" readonly="" value="<?php echo $username ;?>"></td>
                                                <td><input value="<?php echo $profile;?>" required type="file" name="editprofile" class="form-control"></td>
                                                <td><input class="btn btn-success btn btn-sm" name="submit" type="submit" value="Update" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> 
                            </form>
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
</body>

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/table_manage by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Apr 2017 15:21:17 GMT -->
</html>