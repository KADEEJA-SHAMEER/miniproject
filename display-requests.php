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
      .job-card {
     width:50%;
     border-radius:10px;
      border: 1px solid #ddd;
      padding: 20px;
      margin: 20px  300px;
      box-shadow: 0 0 10px black;
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
        $sql2="SELECT * FROM `job_application` WHERE  `job_apply_id`='$apply_id' and `$user_id`='$seeker_id'";
        $data3=mysqli_query($conn,$sql2);
        if($data3)
        {
          $row3=mysqli_fetch_array($data3);
        ?>
         <h2>Employment Information</h2>
         <p> Experience <?php echo $row1['experience'];?></p>
         <p>Availability:<?php echo $row1['availability']; ?></p>
         <p>applied date: <?php echo $row1['apply_date']; ?></p>
         <?php 
       echo "<form action='' method='post'> 
       <input type='hidden' name='seeker_id' value='".$row1['user_id']."'> 
       <label>Application status :</label> 
       <select name='status' required> 
       <option value='pending' ".(($row['application_status'] == 'pending') ? 'selected' : '').">PENDING</option> 
       <option value='approved' ".(($row['application_status'] == 'approved') ? 'selected' : '').">APPROVED</option> 
       <option value='rejected' ".(($row['application_status'] == 'rejected') ? 'selected' : '').">REJECTED</option> 
       </select> 
       <button type='submit' name='confirm'>CONFIRM</button> 
       </form>";
?>
</div>
<?php
        }
        else
        {
            echo"no data retrieved";
        }
        }
      if(isset($_POST['confirm']))
      {
        $seeker_id=$_POST['seeker_id'];
        $status=$_POST['status'];
        $sql3="UPDATE `job_application` SET `application_status`='$status' WHERE `user_id`='$seeker_id'";
        if($conn->query($sql3)===FALSE){
          die("error updating value: ".$conn->error);
      }else{
        echo "<script>alert('UPDATED SUCCESSFULLY')</script>";
      }
      }
      ?>
</body>
</html>