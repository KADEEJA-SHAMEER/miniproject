<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
  body {
    font-family: Arial, sans-serif;
    background-color:  #f0f0f0;
  }

  h1 {
    text-align: center;
    color: black;
  }

  table {
    border-collapse: collapse;
    width: 80%;
    margin: 20px auto;
  }

  th, td {
    border: 1px solid black;
    padding: 10px;
    text-align: left;
    background-color: black;
    color:white;
  }

  th {
    background-color: black;
    color:white;
  }
  button[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  button[type="submit"]:hover {
    background-color: #3e8e41;
  }
  </style>
</head>
<body>
<?php
   require_once("connect.php");
   session_start();
   $user_id = $_SESSION['user_id'];
   $sql="SELECT * FROM job_posting WHERE `status`=true";
   $data=mysqli_query($conn,$sql);
   if(mysqli_num_rows($data)<=0)
   {
    echo "<script>alert('No posted jobs found ')</script>";
   }
  else
   {
    echo "<h1>JOBS YOU POSTED</h1>";
    echo "<table border=1>";
    echo"<tr>";
    echo "<th>JOB TITLE</th>";
    echo"<th>CONTACT NO</th>";
    echo"<th>SCHEDULE TYPE</TH>";
    echo"<th>JOB TYPE</TH>";
    echo "<th>SCHEDULE REQUIREMENT</th>";
    echo "<th>LOCATION</th>";
    echo "<th>DESCRIPTION</th>";
    echo "<th>POSTED DATE</th>";
    echo"<th>SALARY</th>";
    echo"<th>STATUS</th>";
    echo "</tr>";
     while($row=mysqli_fetch_array($data))
     {
        echo"<form action='' method='post'>";
        echo "<input type='hidden' name='post_id' value=".$row['job_post_id'].">";
        echo"<tr>";
        echo "<td>".$row['job_title']."</td>";
        echo"<td>".$row['contact_no']."</td>";
        echo"<td>".$row['schedule_type']."</td>";
        echo"<td>".$row['job_type']."</td>";
        echo "<td>".$row['schedule_requirement']."</td>";
        echo "<td>".$row['location']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$row['posted_date']."</td>";
        echo "<td>".$row['salary']."</td>";
        if($row['admin_status'])
        {
            echo"<td> APPROVED</td>";
        }
        else
           echo "<td><button type=submit name=confirm>CONFIRM</button></td>";
        echo "<td><button type=submit name=remove>REMOVE</button></td>";
        echo "</tr>";
        echo "</form>";
     }
     echo"</table>";
   }
   if(isset($_POST['confirm']))
   {
    $post_id=$_POST['post_id'];
    $sql="UPDATE job_posting SET `admin_status`=true WHERE `job_post_id`='$post_id'";
    $data=mysqli_query($conn,$sql);
    if($data)
     {
        echo"<script>alert('status updated successfully')</script>";
     }
   }
   if(isset('remove'))
   {
    $post_id=$_POST['post_id'];
    $sql="UPDATE job_posting SET `status`=false WHERE `job_post_id`='$post_id'";
    $data=mysqli_query($conn,$sql);
    if($data)
     {
        echo"<script>alert('Post removed successfully')</script>";
     }
   }
   ?>
</body>
</html>