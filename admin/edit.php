<?php
    include('../db.php');
	$code = "";
    $name = "";
    $phone = "";
    $Email = "";
    $editid = "";
    if (isset($_GET['edit'])) {
        $editid = $_GET['edit'];
    }
?>
<?php
include('../db.php');
$id=$_GET['edit'];
$query = "SELECT * FROM member WHERE id='".$id."'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error());
$row = mysqli_fetch_assoc($result);
?>
    <?php
        include("topheader.php");
    ?>
<div id="page-wrapper">
    <div class="form">
    <?php
    	$return = "";
    	if (isset($_POST['editname'])) {
            $editname =$_POST['editname'];
            $editcode = $_POST['editcode'];
            $editphone = $_POST['editphone'];
            $editemail = $_POST['editemail'];
            $update="UPDATE member SET code='".$editcode."', member_name='".$editname."', member_phone='".$editphone."', member_email='".$editemail."' where id='".$editid."'";
            mysqli_query($con, $update) or die(mysqli_error());
            $return.='<p style="color: green; margin-top: 40px; margin: auto;">
                        member updated successfully!</p><br>
                        <a href="member">
                        <button class="btn btn-primary btn btn-sm">
                    Return</button></a>';
        }
        else {
            $id=$_GET['edit'];
            $query = "SELECT * from member where id='".$id."'"; 
            $result = mysqli_query($con, $query) or die ( mysqli_error());
            $row = mysqli_fetch_assoc($result);
    ?>
<div class="panel panel-primary">
    <div class="panel-heading">
    EDIT <?php echo $row['member_name']; ?>
    </div>
        <div class="table table-responsive">
            <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>code</th>
                    <th>Name</th>
                    <th>phone</th>
                    <th>Email</th>
                    <th>save</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form name="form" method="post" action="" enctype="multipart/form-data">
                        <td><input type="text" name="editcode" required value="<?php echo $row['code'];?>" /></td>
                        <td><input type="text" name="editname" required value="<?php echo $row['member_name'];?>" /></td>
                        <td><input type="telephone" name="editphone" required value="<?php echo $row['member_phone'];?>" /></td>
                        <td><input type="email" name="editemail" required value="<?php echo $row['member_email'];?>" /></td>
                        <td><input class="btn btn-primary btn btn-sm" name="submit" type="submit" value="Update" /></td>
                    </form>
                </tr>
            </tbody>
            </table>
            </div> 
     
        <?php } ?>
        <div>
            <p style="margin-top: 60px;"><?php echo $return; ?></p>
        </div>
    </div>
</div>
</div>
</body>
</html>

