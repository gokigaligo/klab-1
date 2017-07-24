<?php
/* watch the video for detailed instructions */
$to = "irasaac@gmail.com";
$from = "Imana@mwijuru.com";
$message = "test sms\n .";
$headers = "From: $from\n";
mail($to, '', $message, $headers);
?>