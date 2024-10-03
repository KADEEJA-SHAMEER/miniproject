<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    table {
    width: 10%;
    margin: 30px auto;
    border-collapse: collapse;
    border-color: black;
    border-width: 5px;
  }
  
  th {
    background-color: #f0f0f0;
    padding: 5px;
    border: 2px solid #000000;
  }
  
  td {
    padding: 2px;
    border: 2px solid #000000;
  }
  input, textarea {
  border: none;
  outline: none;
}

        </style>
</head>
<body>
   <h1>JOBS YOU POSTED</h1>
   <?php
   require_once("connect.php");
   session_start();
   $user_id = $_SESSION['user_id'];
   $sql="SELECT * FROM job_posting WHERE user_id=$user_id";
   $data=mysqli_query($conn,$sql);
   if(mysqli_num_rows($data)<=0)
   {
    echo "<script><alert>No posted jobs found for this user</alert></script>";
   }
  else
   {
    echo "<table border=1>";
    echo"<tr>";
    echo "<th>JOB TITLE</th>";
    echo "<th>SCHEDULE REQUIREMENT</th>";
    echo "<th>LOCATION</th>";
    echo "<th>DESCRIPTION</th>";
    echo "<th>POSTED DATE</th>";
    echo"<th>SALARY</th>";
    echo "</tr>";
     while($row=mysqli_fetch_array($data))
     {
        echo"<form action='' method='post'>";
        echo"<tr>";
        echo "<td><input type='text' name='job_title' value=".$row['job_title']."></td>";
        echo "<td><textarea name='schedule_req' rows=3 cols=50 >".$row['schedule_requirement']."</textarea></td>";
        echo "<td><textarea name='location' rows=5 cols='50'>".$row['location']."</textarea></td>";
        echo "<td> <textarea name='description' rows=5 cols=50 >".$row['description']."</textarea></td>";
        echo "<td><input type='date' name='post_date' value=".$row['posted_date']."></td>";
        echo "<td> <input type='number' name='salary' value=".$row['salary']."></td>";
        echo "<td><button type=submit name=update>UPDATE</button>";
        echo "<td><button type=submit name=delete>DELETE</button>";
        echo "</tr>";
    }
    echo "</table>";
   }
   ?>
</body>
</html>