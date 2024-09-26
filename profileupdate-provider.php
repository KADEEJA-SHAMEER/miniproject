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
        <label>Enter your company details:</label><br>
        <label>Company name:</label><input type="text" name="company_name" value="<?php echo $row['company_name']; ?>"><br>
        <label>Phone Number:</label><input type="text" name="phn_no"  value="<?php echo $row['phone_no']; ?>"><br>
        <label>Industry:</label><input type="text" name="industry" value="<?php echo $row['industry']; ?>"><br>
        <label>Company address:</label><textarea name="address"rows="3" cols="50"><?php echo $row['address']; ?></textarea><br>
        <button type="submit" name="update">Update Profile</button>
    </form>
<?php
if(isset($_POST['update']))
{
    $company_name=$_POST['company_name'];
    $phn_no=$_POST['phn_no'];
    $industry=$_POST['industry'];
    $address=$_POST['address'];

    $sqll = "UPDATE `job_provider` SET `company_name`='$company_name', `phone_no`='$phn_no', `industry`='$industry', `address`='$address' WHERE `user_id`='$user_id'";
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