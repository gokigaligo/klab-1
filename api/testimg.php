<!DOCTYPE html>
<html>
<head>
	<title>Testing uploading</title>
</head>
<body>
<form action="testimg.php" method="POST" enctype="multipart/form-data">
	<input id="image" class="data" type="file" name="image" placeholder="optional image Here" onchange="checkPhoto(this)">
	<input type="submit" value="uploading">
</form>
</body>
</html>
<?php

include("group.php");
	if(isset($_FILES['image']['name'])){
		echo $name=$_FILES['image']['name'];
		echo $tmp=$_FILES['image']['tmp_name'];

		$state=uploadImage($name,$tmp);

		if($state==true)
		{
			echo "image uploaded success";
		}
		else
		{
			echo "image uploaded failed";
		}
	}
?>