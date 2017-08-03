
<?php
function uploadImage($image,$tmp){
$target="./" .basename($image);
if(move_uploaded_file($tmp, $target))
{
	return true;
}
else
{
	return false;
}
}
?>