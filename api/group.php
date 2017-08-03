<?php
function uploadImage($image,$tmp){
	$target="../groupimg/" .basename($image);
	if(move_uploaded_file($tmp, $target))
	{
		return true;
	}
	else
	{
		return false;
	}
}

if(isset($_FILES['image']['name'])){
		echo $name=$_FILES['image']['name'];
		echo '<br/>'.$tmp=$_FILES['image']['tmp_name'];

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