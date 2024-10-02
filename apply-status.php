<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style-display.css">
</head>
<body>
<?php
require_once ("connect.php");
session_start(); 
$user_id = $_SESSION['user_id'];
$sql="SELECT * FROM job_application where user_id=$user_id";
$data=mysqli_query($conn,$sql);
if(mysqli_num_rows($data)<=0)
{
    echo "no job application found for this user";
}
else
{
     echo "<table border=1>";
     echo "<tr>";
     echo "<th> Application ID</th>";
     echo "<th> Job Title</th>";
     echo "<th>  Application Status</th>";
     echo "<th> Applied Date</th>";
     echo "</tr>";
  while($row=mysqli_fetch_array($data))
  {  
    $post_id=$row['job_post_id'];
     echo"<tr>";
     echo"<td>".$row['job_apply_id']."</td>";
     $sqll="SELECT  `job_title` FROM `job_posting` WHERE `job_post_id`=$post_id";
     $data2=mysqli_query($conn,$sqll);
     $res = mysqli_fetch_array($data2);
     echo"<td>". $res['job_title']."</td>";
     echo"<td>".$row['application_status']."</td>";
     echo"<td>".$row['apply_date']."</td>";
     echo "</tr>";
  }
  echo"</table>";
}
?>
</body>
</html>