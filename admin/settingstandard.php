
<?php   

    include ("../db.php");
    $sms = "";
    $confirm_delete = "";
    if (isset($_POST['usr'])) {
        $user = $_POST['usr'];
        $password = $_POST['psw'];
        $category = $_POST['category'];
        $usrname = $_POST['usrname'];
        $usrphone = $_POST['usr_phone'];
        $usr_pic = $_FILES['usr_pic']['name'];
        $target_dir = "../img/user/";
        $target_file = $target_dir . basename($_FILES["usr_pic"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["usr_pic"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["usr_pic"]["size"] > 100000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["usr_pic"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["usr_pic"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }  
        $sqlselect = $con ->query("SELECT * FROM users WHERE name = '$usrname' AND email = '$user'");
        $count = mysqli_num_rows($sqlselect);
        if ($count > 0) {
            $sms.= '<p style="color: red;">'.$usrname.', already exit in database. try to add another</p>';
        }
        else{
            $sqlInsert = $con ->query("INSERT INTO users(email,phone,password,profile,category,name) VALUES('$user', '$usrphone', '$password', '$usr_pic', '$category', '$usrname')");
            $sms.= '<p style="color: green;">'.$usrname.' successfully added to your users</p>';
        }
    }
 ?>
<?php
    include '../db.php';
    if (isset($_GET['delete'])) {
        $fetch_name_of_usr = $con ->query("SELECT * FROM users WHERE id = '".$_GET['delete']."'");
        $rowname = mysqli_fetch_array($fetch_name_of_usr);
        $name = $rowname['name'];
        $sqlDelete = $con ->query("DELETE FROM users WHERE id='".$_GET['delete']."'");
        $confirm_delete .= '<p style="color: green; text-align: center;">'.$name.' Has been deleted from your users</p>';
        if ($sqlDelete) {
            unlink("../img/user/".$_GET['pic']); 
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
        <div id="content" class="content content-full-width">
            <!-- begin vertical-box -->
            <div class="vertical-box">
                <!-- begin vertical-box-column -->
                <div class="vertical-box-column width-250">
                    <!-- begin wrapper -->
                    <div class="wrapper bg-silver text-center">
                        <a href="javascript: void();" class="btn btn-success p-l-40 p-r-40 btn-sm">
                           <i class="fa fa-cog"></i> Settings
                        </a>
                    </div>
                    <!-- end wrapper -->

                    <!-- begin wrapper -->
                    <div class="wrapper">
                        <p><b>FOLDERS</b></p>
                        <ul class="nav nav-pills nav-stacked nav-sm">
                            <li class="active">
                                <a href="javascript: void();" data-toggle="modal" data-target="#Account"><i class="fa fa-cog fa-fw m-r-5"></i> Account Settings </a>
                            </li>
                            <li class="active">
                                <a href="javascript: void();" data-toggle="modal" data-target="#changepassword"><i class="fa fa-cog fa-fw m-r-5"></i> Change Password </a>
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
                                <button class="btn btn-sm btn-white" data-toggle="tooltip" data-placement="top" data-t itle="Refresh" data-original-title="" title=""><i class="fa fa-refresh"></i></button>
                            </div>
                            <!-- end btn-group -->
                        </div>
                        <!-- end btn-toolbar -->
                        <?php
                            echo $confirm_delete;
                            echo $sms;
                        ?>
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
    
    <!-- Modal -->
    <div class="modal modal-message fade" id="Account" tabindex="0" role="dialog" aria-labelledb.phpy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $_SESSION['klabusername']; ?>'s Account.</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>no</th>
                                        <th>User Email</th>
                                        <th>User Name</th>
                                        <th>User Phone</th>
                                        <th>category</th>
                                        <th>profile</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    include("../db.php");
                                    $sqlFetchuser = $con ->query("SELECT * FROM users WHERE id = '$userId'");
                                    $n = 0;
                                     while ($row = mysqli_fetch_array($sqlFetchuser)) {
                                        $productId = $row['id'];
                                        echo '<tr class="odd gradeX">
                                            <td>'.++$n.'</td>
                                            <td>'.$row['email'].'</td>
                                            <td>'.$row['name'].'</td>
                                            <td>'.$row['phone'].'</td>
                                            <td>'.$row['category'].'</td>
                                            <td><img class="img-responsive" src="../img/user/'.$row['profile'].'" height="40px" width="60px"></td>
                                            <td class="actions">
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="edituser?edit='.$row['id'].'">
                                                    <i class="fa fa-pencil text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                                <!-- /.table-responsive -->
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

    <!-- Modal -->
    <div class="modal modal-message fade" id="changepassword" tabindex="0" role="dialog" aria-labelledb.phpy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $_SESSION['klabusername']; ?>'s Account.</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <i id="response"></i>
                                    <tr>
                                        <th>Old Password</th>
                                        <th>New Password</th>
                                        <th>Change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <!-- <form action="settings" enctype="multipart/form-data" method="post"> -->
                                            <td><input type="password" class="form-control" placeholder="Old Password" name="Oldpass" id="Oldpass" required>
                                            <td><input type="password" class="form-control" placeholder="New Password" name="Newpass" id="Newpass" required></td>
                                            <td><button id="change" type="button" class="btn btn-success btn-sm" name="change">Change</button></td>
                                            
                                        <!-- </form> -->
                                    </tr>
                                </tbody>
                            </table>
                                <!-- /.table-responsive -->
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
    $("#change").click(function() {
      var Oldpass = $("#Oldpass").val();
      var Newpass = $("#Newpass").val();
      $.ajax ({
        url: "changepassword.php",
        type: "POST",
        async: false,
        data: {
          "Oldpass" : Oldpass,
          "Newpass" : Newpass
        },
        success: function(data) {
          $("#response").html(data);
        }
      })
    });
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
            $("#notif").html(data);
        }
        })
    });
  });
</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/email_inbox_v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Apr 2017 15:15:14 GMT -->
</html>
