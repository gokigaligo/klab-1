<?php
$uploadpath="../profileimg/$name.jpg";
file_put_contents($uploadpath,base64_decode($image));
echo('image uploaded successfully');
?>
	