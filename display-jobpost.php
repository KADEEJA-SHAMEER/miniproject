<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      *{
        margin:0;
        padding:0;
        box-sizing:border-box;
      }
      h1{
        text-align:center;
        margin-bottom:20px;
      }
    table {
    width: 100%;
  /*  margin: 20px auto;*/
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
 width:100%;
 height:100%;
 border:none;
 outline:none;
 font-size:20px;
 text-align:center;
  }
button[type="submit"]{
  width:95%;
  padding:7px;
  background-color:#333;
  color:white;
  border:none;
  cursor:pointer;
  margin-bottom:10px;
  font-size:16px;
}
button[type="submit"]:hover{
background-color:red;
}
        </style>
</head>
<body>
   
   <?php
   require_once("connect.php");
   session_start();
   $user_id = $_SESSION['user_id'];
   $sql="SELECT * FROM job_posting WHERE user_id=$user_id AND `status`=true";
   $data=mysqli_query($conn,$sql);
   if(mysqli_num_rows($data)<=0)
   {
    echo "<script>alert('No posted jobs found for this user')</script>";
   }
  else
   {
    echo "<h1>JOBS YOU POSTED</h1>";
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
        echo "<input type='hidden' name='post_id' value=".$row['job_post_id'].">";
        echo"<tr>";
        echo "<td><input type='text' name='jobtitle' value=".$row['job_title']."></td>";
        echo "<td><textarea name='schedule_req' rows=3 cols=50 >".$row['schedule_requirement']."</textarea></td>";
        echo "<td><textarea name='location' rows=5 cols='50'>".$row['location']."</textarea></td>";
        echo "<td> <textarea name='description' rows=5 cols=50 >".$row['description']."</textarea></td>";
        echo "<td><input type='date' name='post_date' value=".$row['posted_date']."></td>";
        echo "<td> <input type='number' name='salary' value=".$row['salary']."></td>";
        echo "<td><button type=submit name=update>UPDATE</button></td>";
        echo "<td><button type=submit name=delete>DELETE</button></td>";
        echo "</tr>";
        echo "</form>";
    }
    echo "</table>";
   }
   if(isset($_POST['update']))
   {
    $post_id=$_POST['post_id'];
    $job_title=$_POST['jobtitle'];
    $schedule_req=$_POST['schedule_req'];
    $location=$_POST['location'];
    $description=$_POST['description'];
    $post_date=$_POST['post_date'];
    $salary=$_POST['salary'];
    $sql="UPDATE `job_posting` SET `job_title`='$job_title',
    `schedule_requirement`='$schedule_req',`location`='$location',`description`='$description',
    `posted_date`='$post_date',`salary`='$salary' WHERE `job_post_id`='$post_id'";
     if($conn->query($sql)===FALSE){
      die("error updating value: ".$conn->error);
  }
   }
   if(isset($_POST['delete']))
   {
    $post_id=$_POST['post_id'];
    $sql="UPDATE `job_posting` SET `status`=false WHERE `job_post_id`='$post_id' ";
    if($conn->query($sql)===FALSE){
      die("error updating value: ".$conn->error);
  }else{
    echo "<script>alert('POST REMOVED SUCCESSFULLY')</script>";
  }
   }
   ?>
</body>
</html>