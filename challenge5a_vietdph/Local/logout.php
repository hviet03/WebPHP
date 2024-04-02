<?php
session_start();
 
$_SESSION = array();
session_regenerate_id(true); // Generate a new session ID
session_destroy();

header("location: login.php");
exit;
?>