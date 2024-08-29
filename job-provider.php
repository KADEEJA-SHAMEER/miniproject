<?php 
require_once("connect.php");
ession_start(); // Start the session
$user_id = $_SESSION['user_id']; // Access the session variable

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
    $sql="INSERT INTO `job_provider`(`user_id` `company_name`, `phone_no`, `industry`, `address`) VALUES 
    ('$user_id','$company_name','$phn_no','$industry','$address')";
        $data=mysqli_query($conn,$sql);
        if(!$data)
        {
                echo "error inserting values ";
        }
}
?>