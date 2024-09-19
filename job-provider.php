<?php 
require_once("connect.php");
session_start(); 
$user_id =$_SESSION['user_id']; 
if(isset($_POST['update']))
{
    $company_name=$_POST['company_name'];
    $phn_no=$_POST['phn_no'];
    $industry=$_POST['industry'];
    $address=$_POST['address'];
    $sql="UPDATE  `users` SET `first_login`='false' WHERE `user_id`=$user_id";
    $data=mysqli_query($conn,$sql);
    if(!$data)
    {
            echo "error inupdation ";
    }
    $sqll="INSERT INTO `job_provider`(`user_id`, `company_name`, `phone_no`, `industry`, `address`) VALUES 
    ('$user_id','$company_name','$phn_no','$industry','$address')";
        $data2=mysqli_query($conn,$sqll);
        if(!$data2)
        {
                echo "error inserting values ";
        }
}
?>