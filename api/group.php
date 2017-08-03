<?php
//$image=$_POST['image'];
//$name=$_POST['name'];
//$uploadpath="../groupimg/$name.jpg";
//file_put_contents($uploadpath,base64_decode($image));
//echo('image uploaded successfully');



if ($_FILES['image']['tmp_name'] != "") {
	    // Place image in the folder 
	    move_uploaded_file($_FILES['fileField']['tmp_name'], "../groupimg/testing.jpg");
	}
?>

