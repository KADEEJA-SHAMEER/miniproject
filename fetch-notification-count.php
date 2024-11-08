<?php
session_start(); // Ensure session is started to get user_id
require_once("connect.php"); // Include your database connection

$user_id = $_SESSION['user_id']; // Get the user ID from the session (adjust as needed)

// Get the count of unread notifications
$count_sql = "SELECT COUNT(*) AS unread_count FROM `notifications` WHERE `user_id` = '$user_id' AND `status` = 'unread'";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);

echo $count_row['unread_count']; // Output the count of unread notifications
?>