<?php
require_once("connect.php");
if(isset($_POST['REGISTER']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pword=$_POST['pword'];
    $cpword=$_POST['cpword'];
    $role=$_POST['role'];
    if($pword == $cpword)
    {
        $sql="INSERT INTO `users`(`Name`, `email`, `password`, `role`) VALUES 
        ('$name','$email','$pword','$role')";
        $data=mysqli_query($conn,$sql);
        if(!$data)
        {
                echo "error inserting values ";
        }
        header("Location: /miniproject/login.php");
    }
    else{
        echo "<script><alert>password doesn't match re enter</alert></script>";
    }
}
?>