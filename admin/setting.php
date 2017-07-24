<?php
    include ("../db.php");
    $sms = "";
    $product_name = "";
    session_start();
    if (isset($_SESSION['name'])) {
        $name = $_SESSION['name'];
        $password = $_SESSION['password'];
    }
    elseif (!isset($_SESSION['name'])) {
        header("location: login");
    }
    if (isset($_POST['usr'])) {
            $user = $_POST['usr'];
            $password = $_POST['psw'];
            $category = $_POST['category'];
            $usrname = $_POST['usrname'];
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
            if ($_FILES["usr_pic"]["size"] > 1000000) {
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
                $sqlInsert = $con ->query("INSERT INTO users(email,password,profile,category,name) VALUES('$user', '$password', '$usr_pic', '$category', '$usrname')");
                $sms = '<p style="color: green;">'.$usrname.' successfully added to your users</p>';
            }
        }
    if (isset($_GET['delete'])) {
        $sqlDelete = $con ->query("DELETE FROM users WHERE id='".$_GET['delete']."'");
     }

?>

    <?php
        include("heading.php");
    ?>
<div  id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    USER SETTING
                </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="row">
                    <div class="col-lg-6">
                        <!-- Button trigger modal -->
                        <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">
                            ADD <span  class="fa fa-plus"></span>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade modal-lg" id="myModal" tabindex="0" role="dialog" aria-labelledb.phpy="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">add user</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-responsive table table-condensed table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="180px">user Email</th>
                                                            <th width="180px">user Name</th>
                                                            <th width="150px">Password</th>
                                                            <th width="120px">category</th>
                                                            <th width="150px">profile</th>
                                                            <th width="80px">save</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                        <form action="setting" method="post" enctype="multipart/form-data">
                                                            <td><input type="text" name="usr" class="form-control" required></td>
                                                            <td><input type="text" name="usrname" class="form-control" required></td>
                                                            <td><input type="password" name="psw" class="form-control" required></td>
                                                            <td>
                                                            <select name="category">
                                                                <option value="administrator">administrator</option>
                                                                <option value="other">other user</option>
                                                            </select></td>
                                                            <td><input type="file" name="usr_pic" class="form-control" required></td>
                                                            <td class="actions">
                                                                <button type="submit" name="submit"  class="btn btn-success btn-xs btn-custom waves-effect m-b-3"><i class="fa fa-save success"></i></button>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <button type="reset" name="reset" class="btn btn-primary btn-xs  btn-custom waves-effect m-b-3"><i class="fa fa-times"></i></button>
                                                            </td>
                                                        </form>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
                    </div>
                    <!-- /.col-lg-6 -->
                 </div>
                <!-- /.row -->
                   <br>
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
            <?php
                echo $sms;
            ?>
                <tr>
                    <th>no</th>
                    <th>User Email</th>
                    <th>User Name</th>
                    <th>category</th>
                    <th>profile</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                include("../db.php");
                $sqlFetchuser = $con ->query("SELECT * FROM users ORDER BY id DESC");
                $n = 0;
                 while ($row = mysqli_fetch_array($sqlFetchuser)) {
                    $n++;
                    $productId = $row['id'];
                    echo '<tr class="odd gradeX">
                        <td>'.$n++.'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['category'].'</td>
                        <td><img class="img-responsive" src="../img/user/'.$row['profile'].'" height="40px" width="60px"></td>
                        <td class="actions">
                            &nbsp;&nbsp;&nbsp;
                            <a href="edit2?edit='.$row['id'].'" <i class="fa fa-pencil text-primary"></i></a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="?delete='.$row['id'].'& pic='.$row['profile'].'"><i class="fa fa-trash-o text-danger"></i></a>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
            <!-- /.table-responsive -->
        </div>
        <!--end of updatedetails-->
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!--/ . page-warraper-->

    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
</body>
</html>