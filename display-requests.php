<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
      <h1>APPLICATION FOR JOBS</h1>
      <?php
      require_once("connect.php");
       session_start();
       $user_id = $_SESSION['user_id'];
       $sql="SELECT * FROM job_application WHERE provider_id='$user_id'";
       $data=mysqli_query($conn,$sql);
       if($data)
       {
         echo "<table>";
         echo "<th>"
       }
       
</body>
</html>