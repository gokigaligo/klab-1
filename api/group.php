<?php
$image=$_POST['image'];
$name=$_POST['name'];
$uploadpath="../groupimg/$name.jpg";
file_put_contents($uploadpath,base64_decode($image));
echo('groupimage uploaded successfully');
?>