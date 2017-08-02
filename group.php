<?php
$con=mysqli_connect("localhost","root","");
if($con)
{
	$db=mysqli_select_db($con,"uplus");
	if($db)
	{
		$image=$_POST['image'];
		$name=$_POST['name'];

		$sql="INSERT INTO groupimg(name)VALUES('$name')";
		$uploadpath="groupimg/$name.jpg";

		if(mysqli_query($con,$sql))
		{
			file_put_contents($uploadpath,base64_decode($image));
			echo('image uploaded successfully');
		}
		else
		{
		echo('image uploaded failed');	
		}
	}
}
else
{
	echo('image uploaded failed');		
}
mysqli_close($con);
?>