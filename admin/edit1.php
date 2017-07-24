<?php
    require('../db.php');
    $productname = "";
    $picture = "";
    $editid = "";
    if (isset($_GET['edit'])) {
        $editid = $_GET['edit'];
    }
    else{
?>
        <script type="text/javascript">
            window.location.href = 'productlist';
        </script>
<?php
    }
?>
<?php

require('../db.php');
$id=$_GET['edit'];
$query = "SELECT * FROM products WHERE id='".$id."'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error());
$row = mysqli_fetch_assoc($result);
?>
    <?php
        include("heading.php");
    ?>
<div  id="page-wrapper">
    <div class="form">
    <?php
    $status = "";
    $product_pic = "";
    $return = "";
        if (isset($_FILES['product_pic'])) {
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
                //echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["product_pic"]["tmp_name"], $target_file)) {
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            $editname =$_POST['editname'];
            $editcode = $_POST['editcode'];
            $editmember_price = $_POST['editmember_price'];
            $editnon_member_price = $_POST['editnon_member_price'];
            $editcategory = $_POST['editcategory'];
            $update="update products set code='".$editcode."', Name='".$editname."', price_member='".$editmember_price."', price_non_member='".$editnon_member_price."',category='".$editcategory."', pic='".$product_pic."' where id='".$editid."'";
            mysqli_query($con, $update) or die(mysqli_error());
            $return.='<p style="color: green; margin-top: 40px; margin: auto;">
                        product updated successfully!</p><br><a href="productlist">
                        <button class="btn btn-primary btn btn-sm">
                    Return</button></a>';
            //header("location: productlist");
        }


    else {
        $id=$_GET['edit'];
        $query = "SELECT * from products where id='".$id."'"; 
        $result = mysqli_query($con, $query) or die ( mysqli_error());
        $row = mysqli_fetch_assoc($result);
    ?>
<div class="panel panel-primary">
    <div class="panel-heading">
    EDIT <?php echo $row['Name']; ?>
    </div>
        <form name="form" method="post" action="" enctype="multipart/form-data">
        <div class="table table-responsive">
            <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Member</th>
                    <th>Non Member</th>
                    <th>category</th>
                    <th>picture</th>
                    <th>Save</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td><input type="text" name="editcode" required value="<?php echo $row['code'];?>" /></td>
                <td><input type="text" name="editname" required value="<?php echo $row['Name'];?>" /></td>
                <td><input type="number" name="editmember_price" required value="<?php echo $row['price_member'];?>" /></td>
                <td><input type="number" name="editnon_member_price" required value="<?php echo $row['price_non_member'];?>" /></td>
                <td>
                    <select name="editcategory" class="form-control">
                        <option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
                        <option value="fanta">fanta</option>
                        <option value="tea">tea</option>
                        <option value="coffee">coffee</option>
                        <option value="snacks">snacks</option>
                        <option value="others">others</option>
                    </select>
                </td>
                <td><input type="file" name="product_pic" required></td>
                <td><input class="btn btn-success" name="submit" type="submit" value="Update" /></td>
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

