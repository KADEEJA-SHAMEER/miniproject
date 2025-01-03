<?php
require_once ("connect.php");
session_start(); 
$user_id = $_SESSION['user_id'];
$post_id=$_SESSION['job_id'];
$provider_id=$_SESSION['provider_id'];
if (isset($_POST['apply'])) {
    $experience = htmlspecialchars($_POST['experience']);
    $apply_date = $_POST['apply_date'];
    $availability = htmlspecialchars($_POST['availability']);
    $application_status = $_POST['application_status'];

    $query = "INSERT INTO `job_application` (`user_id`,`provider_id`,`job_post_id`, `apply_date`, `availabilty`,
     `experience`, `application_status`) VALUES ('$user_id','$provider_id','$post_id', '$apply_date', 
     '$availability','$experience', '$application_status')";
    if (mysqli_query($conn, $query)) {
        header('Location: apply-status.php');
        echo "<script>alert('Application submitted successfully.')</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


