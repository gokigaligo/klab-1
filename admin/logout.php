<?php
session_start();
unset($_SESSION['klabusername']);
unset($_SESSION['klabpassword']);
header("location: login");

?>
