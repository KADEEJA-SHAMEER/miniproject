<?php
require_once ("connect.php");
session_start(); 
$user_id = $_SESSION['user_id']; 
if (isset($_POST['submit']))
 {
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $skills = $_POST['skills'];
    $education =mysqli_real_escape_string($conn, $_POST['education']);
    $address = $_POST['address'];
    $seeker_phno = $_POST['seeker_phno'];
    $sql="UPDATE  `users` SET `first_login`=false WHERE `user_id`=$user_id";
    $data=mysqli_query($conn,$sql);
    $query = "INSERT INTO `job_seeker`(`user_id`, `date_of_birth`, `gender`, `skills`, `education`,
     `seeker_address`, `seeker_phno`) VALUES ('$user_id','$dob', '$gender', '$skills', '$education', '$address',
      '$seeker_phno')";
    if(mysqli_query($conn, $query)) {
        header('Location: dashboard-seeker.html');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

