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
        text-align: center;
        color: black;
      }
      body {
    font-family: Arial, sans-serif;
    background-color:  #f0f0f0;
  }
  table {
  border-collapse: collapse;
  width: auto; /* Adjusts the width based on content */
  margin: 20px auto; /* Centers the table */
}

th, td {
  border: 1px solid black;
  padding: 10px;
  text-align: left;
  background-color: black;
  color: white;
  white-space: nowrap; /* Prevents text from wrapping to fit content in each cell */
}

th {
  background-color: black;
  color: white;
}

/* Style for the form container */
.display {
  width: 60%;
  margin: auto;
  padding: 20px;
  background-color: #f8f8f8;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
  font-family: Arial, sans-serif;
}

/* Style for form labels */
.display label {
  display: block;
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 5px;
  color: #333;
}

/* Style for text inputs */
.display input[type="text"],
.display input[type="date"],
.display input[type="number"],
.display select,
.display textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  box-sizing: border-box;
}

/* Style for dropdown menus (selects) */
.display select {
  background-color: #fff;
  cursor: pointer;
}

/* Style for text areas */
.display textarea {
  resize: vertical; /* allows vertical resize but prevents horizontal */
  min-height: 80px;
}

/* Style for the submit button */
.display button[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

/* Hover effect for the submit button */
.display button[type="submit"]:hover {
  background-color: #45a049;
}

/* Style for status text (e.g., APPROVED, PENDING) */
.display .status {
  font-weight: bold;
  padding: 5px;
  margin-bottom: 15px;
}

.display .status.approved {
  color: green;
}

.display .status.pending {
  color: red;
}

/* Style for spacing between form elements */
.display > *:not(:last-child) {
  margin-bottom: 15px;
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
    echo "<th>POSTED DATE</th>";
    echo "<th>POST EXPIRE DATE</TH>";
    echo"<th>STATUS</th>";
    echo "<th></th><th></th>";
    echo "</tr>";
     while($row=mysqli_fetch_array($data))
     {
      echo "<tr>";
      echo"<td>".$row['job_title']."</td>";
      echo"<td> ".$row['posted_date']."</td>";
      echo"<td> ".$row['exp_date']."</td>";
      if($row['admin_status'])
        {
          echo "<td>APPROVED</td>";
        }
        else
        {
          echo"<td>PENDING</td>";
        }
      echo"<form action='display-jobpost.php'method='post' target='frame2'>";
      echo "<input type='hidden' name='post_id' value=".$row['job_post_id'].">";
      echo "<td><button type=submit name=edit>EDIT</button></td>";
      echo "<td><button type=submit name=delete>DELETE</button></td>";
      echo"</form>";
      echo"</tr>";
     }
     echo "</table>";
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
   if(isset($_POST['edit']))
      {
        $post_id=$_POST['post_id'];
        $sql="SELECT * FROM `job_posting` WHERE `job_post_id`='$post_id'";
        $data=mysqli_query($conn,$sql);
        if(!$data)
        {
           echo "<script>alert('No job post found for this post id')</script>";
        }
        else
        {
        $row1=mysqli_fetch_array($data);  
        echo "<h1>EDIT YOUR JOB POST</h1>";
        echo "<form  class='display' action='edit-job.php' method ='post' >";
        echo "<label>Enter your job title</label><br>";
        echo "<input type='hidden' name='post_id' value=".$row1['job_post_id'].">"; 
        echo "<input type='text' name='jobtitle' value=". htmlspecialchars($row1['job_title']).">";
        echo '<select name="job_type" required>
        <option value="Retail" ' . ($row1['job_type'] == 'Retail' ? 'selected' : '') . '>Retail</option>
        <option value="Hospitality" ' . ($row1['job_type'] == 'Hospitality' ? 'selected' : '') . '>Hospitality</option>
        <option value="Education" ' . ($row1['job_type'] == 'Education' ? 'selected' : '') . '>Education</option>
        <option value="Healthcare" ' . ($row1['job_type'] == 'Healthcare' ? 'selected' : '') . '>Healthcare</option>
        <option value="Finance" ' . ($row1['job_type'] == 'Finance' ? 'selected' : '') . '>Finance</option>
        <option value="Customer Service" ' . ($row1['job_type'] == 'Customer Service' ? 'selected' : '') . '>Customer Service</option>
        </select>'; 
        echo"<select name='schedule_type' required>
            <option value='Evening & weekend jobs' " . ($row1['schedule_type'] == 'Evening & weekend jobs' ? 'selected' : '') . ">Evening & weekend jobs</option>
            <option value='Flexible hours' " . ($row1['schedule_type'] == 'Flexible hours' ? 'selected' : '') . ">Flexible hours</option>
            </select>";
       echo "<textarea name='schedule_req' rows=3 cols=50 >". htmlspecialchars($row1['schedule_requirement'])."</textarea>";
       echo "<textarea name='location' rows=5 cols='50'>". htmlspecialchars($row1['location'])."</textarea>";
       echo "<textarea name='description' rows='5' cols='50'>" . htmlspecialchars($row1['description']) . "</textarea>";
       echo "<input type='text' name='contact_no' value=".$row1['contact_no'].">";
       echo "<input type='date' name='post_date' value=".$row1['posted_date'].">";
       echo "<input type='date' name='exp_date' value=".$row1['exp_date'].">";
       echo " <input type='number' name='salary' value=".$row1['salary'].">";
       if($row1['admin_status'])
       {
         echo "APPROVED<br><br>";
       }
       else
       {
         echo"PENDING<br><br>";
       }
       echo "<button type=submit name=update>UPDATE</button>";
       echo "</form>";
     }
  }
   ?>
</body>
</html>