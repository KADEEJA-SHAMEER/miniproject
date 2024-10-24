<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .job-card {
     width:50%;
     border-radius:10px;
      border: 1px solid #ddd;
      padding: 20px;
      margin: 20px  300px;
      box-shadow: 0 0 10px black;
    }
    button[type="submit"] {
    width: 50%;
    padding: 10px;
    background-color: #101111;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
  </style>
</head>
<body>
<?php
require_once("connect.php");
session_start();
$user_id= $_SESSION['user_id']; 
$sql="SELECT * FROM job_seeker where user_id='$user_id'";
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
<div class="job-card">
        <h2>YOUR PROFILE</h2>
        <p> Name: <?php echo $row['full_name'];?></p>
        <p>date of birth:<?php echo $row['date_of_birth']; ?></p>
        <p>Gender: <?php echo $row['gender']; ?></p>
        <p> skills: <?php echo $row['skills'];?></p>
        <p>educational status: <?php echo $row['education']; ?></p>
        <p>address: <?php echo $row['seeker_address']; ?></p>
         <p>phone no: <?php echo $row['seeker_phno']; ?></p>
        <form action="profileupdate-seeker.php" method=post>
        <button type=submit name=edit>edit Profile</button>
       </form>
      </div>
</body>
</html>

