<?php
$image=$_POST['image'];
$name=$_POST['name'];
$uploadpath="../groupimg/$name.jpg";
//file_put_contents($uploadpath,base64_decode($image));
//echo('image uploaded successfully');

if(!file_exists($_FILES['name']['tmp_name']) || !is_uploaded_file($_FILES['name']['tmp_name'])) {
    echo 'No upload';
}
?>


