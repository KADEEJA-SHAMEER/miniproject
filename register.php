<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
      <input type="text"  name="name" placeholder="enter your name" required><br>
      <input type="email" name="email" placeholder="enter your email" required><br>
      <input type="password" name="pword"  placeholder="enter password" required><br>
      <input type="password" name="cpword" placeholder="confirm your password" required><br>
      <select name="role" required>
      <option value="job provider">select an aoption</option>
        <option value="job provider">job provider</option>
        <option value="job seeker">job seeker</option>
      </select>
      <button  type="submit" name="REGISTER" >REGISTER</button>
</form>
<?php
require_once("connect.php");
if(isset($_POST['REGISTER']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pword=$_POST['pword'];
    $cpword=$_POST['cpword'];
    $role=$_POST['role'];
    echo "$name";
    echo"$pword";
    echo"$cpword";
    if($pword==$cpword)
    {
        echo "<script><alert>password doesn't match re enter</alert></script>";
        $sql="INSERT INTO `users`(`Name`, `email`, `password`, `role`) VALUES 
        ('$name','$email','$pword','$role')";
        $data=mysqli_query($dbcon,$sql);
        if(!$data)
        {
                echo "error inserting values ";
        }
        header(location:'./login.php');
    }
    else{
        echo "<script><alert>password doesn't match re enter</alert></script>";
    }
}
?>
</body>
</html>