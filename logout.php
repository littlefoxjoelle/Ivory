<?php   
session_start();
ob_start();
unset($_SESSION['user']);
header('Location: autorization.php');
ob_end_flush();
?>



