
<?php
$body="";
if(isset($_FILES['contactsFile'])){
$filename = basename($_FILES['contactsFile']['name']);
$path = $filename;
move_uploaded_file($_FILES['contactsFile']['tmp_name'], $path);
//echo $filename;

include "db.php";
		
// EXCEL BULK INVITATIONS
include ("classes/PHPExcel/IOFactory.php");  
$objPHPExcel = PHPExcel_IOFactory::load($path);  
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)   
{  
	$n=0;		
	$highestRow = $worksheet->getHighestRow();
	for ($row=2; $row<=$highestRow; $row++)
	{
		$n++;
			$id = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
			$member_email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
			include "db.php";
		$sql = $con->query("INSERT INTO member(id, member_email) VALUES('$id', '$member_email')");
		$body.='Birakozwe. Ibicuruzwa Byose bivuyemo, hagiyemo ibikoresho '.$n.' bishya! <a href="index.php">Kanda Hano</a>.';
	}
	
}
}else{
	$body.='
		<form action="testupload.php" method="post" enctype="multipart/form-data">
		  <input type="file" name="contactsFile">
		  <input type="submit" value="upload">
		</form>';
}
// END EXCEL BULK INVITATIONS
?>



<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<?php echo $body;?>
</body>
</html>