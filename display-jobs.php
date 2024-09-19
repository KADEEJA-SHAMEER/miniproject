<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
 <?php
 require_once("connect.php");
 session_start();
 $user_id=12;/*$_SESSION['user_id'];*/
$sql="SELECT * FROM job_posting ";
$data=mysqli_query($conn,$sql);
if(mysqli_num_rows($data)>0)
{
    while($row=mysqli_fetch_array($data))
    {
        
    }
}
 ?>   
</body>
</html>