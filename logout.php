<?php
session_start();

// Unset session variables
unset($_SESSION['user_id']);
unset($_SESSION['job_id']);

// Destroy the session
session_destroy();

// Redirect to login page or homepage
header('Location: login.php');
exit;
?>
