<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .notifications {
    margin-top: 20px;
}

.notification {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.notification p {
    margin: 0;
    font-size: 14px;
}

.notification small {
    font-size: 12px;
    color: #777;
}
</style>
</head>
<body>
<?php
session_start();
require_once("connect.php");

$user_id = $_SESSION['user_id'];

// Fetch unread notifications
$sql = "SELECT * FROM `notifications` WHERE `user_id` = '$user_id' AND `status` = 'unread' ORDER BY `created_at` DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<div class='notifications'>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<div class='notification'>";
        echo "<p>" . htmlspecialchars($row['message']) . "</p>";
        echo "<p><small>Received on: " . $row['created_at'] . "</small></p>";

        // Mark the notification as read
        $notification_id = $row['notification_id'];
        $sql_update = "UPDATE `notifications` SET `status` = 'read' WHERE `notification_id` = '$notification_id'";
        mysqli_query($conn, $sql_update);

        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No new notifications.</p>";
}
?>

</body>
</html>
