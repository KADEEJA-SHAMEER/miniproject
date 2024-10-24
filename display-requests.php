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
      <h1>APPLICATION FOR JOBS YOU POSTED</h1>
      <?php
      require_once("connect.php");
       session_start();
       $user_id = $_SESSION['user_id'];
       $sql="SELECT * FROM job_application WHERE provider_id='$user_id'and `application_status`='pending'";
       $data=mysqli_query($conn,$sql);
       if(mysqli_num_rows($data) > 0) 
       {
            echo"<table>";
            echo "<tr>";
            echo "<th>Name of the applicant</th>";
            echo "<th>Job applied</th>";
            echo "<th>Apply date</th>";
            echo "<th>More details</th>";
            echo "</tr>";
            while($row = mysqli_fetch_array($data))
               {
                 $seeker_id=$row['user_id'];
                 $post_id=$row['job_post_id'];
                 $sql1="SELECT `job_title` FROM `job_posting` WHERE `job_post_id`='$post_id'";
                 $data1=mysqli_query($conn,$sql1);
                 $sqll="SELECT * FROM `job_seeker` WHERE `user_id`='$seeker_id'";
                 $data2=mysqli_query($conn,$sqll);
                 if($data2 && $data1)
                  {
                    $row2 = mysqli_fetch_array($data2);
                    $row1 = mysqli_fetch_array($data1);
                    echo "<tr>";
                    echo"<td>".$row2['full_name']."</td>";
                    echo"<td> ".$row1['job_title']."</td>";
                    echo"<td>".$row['apply_date']."</td>";
                    echo"<form action=''method='post'>";
                    echo"<input type='hidden' name='apply_id'value=".$row['job_apply_id'].">";
                    echo"<input type='hidden' name='seeker_id'value=".$row['user_id'].">";
                    echo "<td><button type='submit' name='details'>View Details</button></td>";
                    echo"</form>";
                    echo"</tr>";
                  }
               }
               echo"</table>";
       }
       else{
        echo"<script>alert('No job request found for this user')</script>";
       }
      if(isset($_POST['details']))
      {
        
      }
      ?>
</body>
</html>