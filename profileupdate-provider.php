<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style-jobprovider.css">
    <script>
        function validate() {
    var phn_no = document.getElementsByName('phn_no')[0].value;
    
    // Check if phone number has 10 digits
    if (phn_no.length !== 10) {
        alert("Phone number must be 10 digits");
        return false;
    }
    
    // Check if all characters are digits
    if (!/^\d+$/.test(phn_no)) {
        alert("Phone number must contain only digits");
        return false;
    }
    
    // If validation passes, return true
    return true;
}

    </script>
</head>
<body>   
<?php
require_once("connect.php");
session_start();
$user_id=10/* $_SESSION['user_id']*/; 
$sql="SELECT * FROM job_provider where user_id='$user_id'";
$data=mysqli_query($conn,$sql);
if($data)
{
  $row=mysqli_fetch_array($data);
  
}
else
{
    echo"no data retrieved";
}
?>
 <form action="" onsubmit="return validate()" method="post">
        <h3>UPDATE YOUR PROFILE</h3>
        <label> name:</label><input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
        <label>Phone Number:</label><input type="text" name="phn_no"  value="<?php echo $row['phone_no']; ?>"><br>
        <button type="submit" name="update">Update Profile</button>
    </form>
<?php
if(isset($_POST['update']))
{
    $name=$_POST['name'];
    $phn_no=$_POST['phn_no'];

    $sqll = "UPDATE `job_provider` SET `name`='$name', `phone_no`='$phn_no'  WHERE `user_id`='$user_id'";
    $data2=mysqli_query($conn,$sqll); 
    if(!$data2)
        {
                echo "error inserting values ";
        }
    else{
        echo"<script><alert>your profile is updated</alert></script>";
        header("Location: profileupdate-provider.php");
        exit;
        
    }
}
?>
</body>
</html>