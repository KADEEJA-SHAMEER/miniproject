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

  .job-card {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    margin: 20px auto;
    width: 80%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .job-card h2 {
    margin-top: 0;
  }

  .job-card p {
    margin-bottom: 20px;
  }

  form {
    margin-bottom: 20px;
  }

  select, input[type="text"], input[type="hidden"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
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
      <h1>DETAILS OF TOTAL APPLICANTS</h1>
      <?php
      require_once("connect.php");
       session_start();
       $user_id = $_SESSION['user_id'];
       $sql="SELECT * FROM job_application WHERE provider_id='$user_id'and `application_status`='approved' or `application_status`='rejected'";
       $data=mysqli_query($conn,$sql);
       if(mysqli_num_rows($data) > 0) 
       {
            echo"<table>";
            echo "<tr>";
            echo "<th>Name of the applicant</th>";
            echo "<th>Job applied</th>";
            echo "<th>Apply date</th>";
            echo "<th> Status</th>";
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
                    echo"<td>".$row['application_status']."</td>";
                    echo"<form action=''method='post' target='frame2'>";
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
        $apply_id=$_POST['apply_id'];
        $seeker_id=$_POST['seeker_id'];
        $sql="SELECT * FROM job_seeker where user_id='$seeker_id'";
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
                <h2>APPLICANT PROFILE</h2>
                <p> Name: <?php echo $row['full_name'];?></p>
                <p>date of birth:<?php echo $row['date_of_birth']; ?></p>
                <p>Gender: <?php echo $row['gender']; ?></p>
                <p> skills: <?php echo $row['skills'];?></p>
                <p>educational status: <?php echo $row['education']; ?></p>
                <p>address: <?php echo $row['seeker_address']; ?></p>
                 <p>phone no: <?php echo $row['seeker_phno']; ?></p>
        <?php
        $sql2="SELECT * FROM `job_application` WHERE  `job_apply_id`='$apply_id' and `user_id`='$seeker_id'";
        $data3=mysqli_query($conn,$sql2);
        if($data3)
        {
          $row3=mysqli_fetch_array($data3);
        ?>
         <h2>Employment Information</h2>
         <p> Experience <?php echo $row3['experience'];?></p>
         <p>Availability:<?php echo $row3['availabilty']; ?></p>
         <p>applied date: <?php echo $row3['apply_date']; ?></p>
         <p> Application status:<?php echo $row3['application_status']; ?></p>
</div>
<?php
        }
        else
        {
            echo"no data retrieved";
        }
        }
     
      
      ?>
</body>
</html>