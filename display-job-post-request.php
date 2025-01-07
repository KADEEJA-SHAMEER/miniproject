<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 20px;
  }

  h1 {
    text-align: center;
    color: black;
    margin-bottom: 20px;
  }

  table {
    border-collapse: collapse;
    width: 90%;  /* Increased width */
    margin: 20px auto;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  }

  th, td {
    border: 1px solid #ddd;
    padding: 15px; /* Increased padding for better readability */
    text-align: left;
    font-size: 14px;
  }

  th {
    background-color: #007bff;
    color: white;
    text-transform: uppercase;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  tr:hover {
    background-color: #e0e0e0;
  }

  button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
  }

  button[type="submit"]:hover {
    background-color: #3e8e41;
  }

  button[disabled] {
    background-color: #ccc;
    cursor: not-allowed;
  }

  /* Additional styling for expired row */
  tr[style*="background-color: #f8d7da;"] {
    background-color: #f8d7da;
    color: #721c24;
  }

  </style>
</head>
<body>
<?php
   require_once("connect.php");   
   $sql = "SELECT * FROM job_posting WHERE `status`=true";
   $data = mysqli_query($conn, $sql);
   
   if (mysqli_num_rows($data) <= 0) {
       echo "<script>alert('No posted jobs found')</script>";
   } else {
       echo "<h1>JOBS YOU POSTED</h1>";
       echo "<table border=1>";
       echo "<tr>";
       echo "<th>JOB TITLE</th>";
       echo "<th>CONTACT NO</th>";
       echo "<th>SCHEDULE TYPE</TH>";
       echo "<th>JOB TYPE</TH>";
       echo "<th>SCHEDULE REQUIREMENT</th>";
       echo "<th>LOCATION</th>";
       echo "<th>DESCRIPTION</th>";
       echo "<th>POSTED DATE</th>";
       echo "<th>POST EXPIRE DATE</th>";
       echo "<th>SALARY</th>";
       echo "<th>STATUS</th>";
       echo "<th></th>";
       echo "</tr>";

       while ($row = mysqli_fetch_array($data)) {
        $isExpired = strtotime($row['exp_date']) < strtotime(date('Y-m-d'));
    
        // Start form for each row
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='post_id' value='".htmlspecialchars($row['job_post_id'], ENT_QUOTES)."'>";
    
        // Highlight expired job posts by changing row color
        echo '<tr' . ($isExpired ? ' style="background-color: #f8d7da;"' : '') . '>';
    
        // Display each column with htmlspecialchars to prevent output issues
        echo "<td>" . htmlspecialchars($row['job_title'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['contact_no'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['schedule_type'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['job_type'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['schedule_requirement'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['location'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['description'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['posted_date'], ENT_QUOTES) . "</td>";
        echo "<td>" . htmlspecialchars($row['exp_date'], ENT_QUOTES) . ($isExpired ? " (Expired)" : "") . "</td>";
        echo "<td>" . htmlspecialchars($row['salary'], ENT_QUOTES) . "</td>";
    
        if ($row['admin_status']) {
            echo "<td> APPROVED</td>";
        } else {
            echo "<td><button type='submit' name='confirm'>CONFIRM</button></td>";
        }
    
        echo "<td><button type='submit' name='remove'" . ($isExpired ? " disabled" : "") . ">REMOVE</button></td>";
        echo "</tr>";
        echo "</form>";
    }
    echo "</table>";
    
   }

   if (isset($_POST['confirm'])) {
       $post_id = $_POST['post_id'];
       $sql = "UPDATE job_posting SET `admin_status`=true WHERE `job_post_id`='$post_id'";
       $data = mysqli_query($conn, $sql);
       if ($data) {
           echo "<script>alert('Status updated successfully')</script>";
       }
   }

   if (isset($_POST['remove'])) {
       $post_id = $_POST['post_id'];
       $sql = "UPDATE job_posting SET `status`=false WHERE `job_post_id`='$post_id'";
       $data = mysqli_query($conn, $sql);
       if ($data) {
           echo "<script>alert('Post removed successfully')</script>";
       }
   }
?>
</body>
</html>