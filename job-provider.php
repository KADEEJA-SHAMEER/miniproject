<?php 
require_once("connect.php");
session_start(); 
$user_id =$_SESSION['user_id']; 
if(isset($_POST['update']))
{
    $company_name=$_POST['name'];
    $phn_no=$_POST['phn_no'];
    $sql="UPDATE  `users` SET `first_login`=false WHERE `user_id`=$user_id";
    $data=mysqli_query($conn,$sql);
    $sqll="INSERT INTO `job_provider`(`user_id`, `name`, `phone_no`) VALUES 
    ('$user_id','$name','$phn_no')";
        $data2=mysqli_query($conn,$sqll);
        if($data2)
        {
               header('Location: dashboard-jobpost.php');
               exit;
        }
        else
        {
                echo "error inserting values";
        }
}
?>