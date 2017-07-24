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
?>
<?php
    require('../db.php');
	$email = "";
    $category = "";
    if (isset($_GET['edit'])) {
        $editid = $_GET['edit'];
    }
?>
<?php

require('../db.php');
$id=$_GET['edit'];
$query = "SELECT * from users where id='".$id."'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error());
$row = mysqli_fetch_assoc($result);
?>
    <?php
        include("heading.php");
    ?>
<div  id="page-wrapper">
    <div class="form">
    <?php
    $return = "";
    $profile = "";
        if (isset($_FILES['profile'])) {
            $profile = $_FILES['profile']['name'];
            $target_dir = "../img/user/";
            $target_file = $target_dir . basename($_FILES["profile"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["profile"]["tmp_name"]);
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
            if ($_FILES["profile"]["size"] > 150000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            $edituser =$_POST['editusr'];
            $editpsw = $_POST['editpsw'];
            $editcategory = $_POST['editcategory'];
            $editname = $_POST['editname'];
            $update="update users set email='".$edituser."', password='".$editpsw."', category='".$editcategory."', profile='".$profile."', name='".$editname."' where id='".$editid."'";
            mysqli_query($con, $update) or die(mysqli_error());
            $return.='<p style="color: green; margin-top: 40px; margin: auto;">
                        user updated successfully!</p><br><a href="setting">
                        <button class="btn btn-primary btn btn-sm">
                    Return</button></a>';
        }


    else {
        $id=$_GET['edit'];
        $query = "SELECT * from users where id='".$id."'"; 
        $result = mysqli_query($con, $query) or die ( mysqli_error());
        $row = mysqli_fetch_assoc($result);
    ?>
<div class="panel panel-primary">
    <div class="panel-heading">
    edit for user who have email of <?php echo $row['email']; ?>
    </div>
        <form name="form" method="post" action="" enctype="multipart/form-data">
            <div class="table table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>password</th>
                            <th>category</th>
                            <th>profile</th>
                            <th>Save</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><input type="email" name="editusr" required value="<?php echo $row['email'];?>" /></td>
                        <td><input type="text" name="editname" required value="<?php echo $row['name'];?>" /></td>
                        <td><input type="text" name="editpsw" value="" placeholder="enter new password" /></td>
                        <td>
                            <select name="editcategory">
                                <option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
                                <option value="administrator">admin</option>
                                <option value="other">other user</option>
                            </select>
                        </td>
                        <td><input type="file" name="profile" required></td>
                        <td><input name="submit" type="submit" value="Update" /></td>
                        </tr>
                    </tbody>
                </table>
            </div> 
        </form>
     
        <?php } ?>

        <P>
            <?php echo  $return; ?>
        </P>
    </div>
</div>
</div>
</body>
</html>

