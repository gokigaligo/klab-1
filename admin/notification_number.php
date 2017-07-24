<?php
    include("../db.php");
    $notification = $con->query("SELECT * FROM notification WHERE seen = '0'");
    $sqlcount = mysqli_num_rows($notification);
    if ($sqlcount < 1) {
    	echo "0";
    }
	else {
	    echo number_format($sqlcount);
    }
?>
								