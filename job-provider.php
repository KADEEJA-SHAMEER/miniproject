<?php 
require_once("connect.php");
/* Profile creation script
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and save profile data
    // ...
    // Update first login flag
    $user->setFirstLogin(false);
    $user->save();
    // Redirect to dashboard or main page
    header('Location: dashboard.php');
    exit;
}*/
if(isset($_POST['update']))
{
    $company_name=$_POST['company_name'];
    $phn_no=$_POST['phn_no'];
    $industry=$_POST['phn_no'];
    $address=$_POST['address'];
    $sql="INSERT INTO `job_provider`(`Name`, `email`, `password`, `role`) VALUES 
        ('$name','$email','$pword','$role')";
        $data=mysqli_query($conn,$sql);
        if(!$data)
        {
                echo "error inserting values ";
        }
}