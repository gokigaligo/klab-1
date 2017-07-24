
<?php
    if(isset($_POST['a'])) {
        include '../db.php';
        $updatenotinum = $con ->query("UPDATE notification SET seen = '1' WHERE id > 0");
    }
?>