<?php
require_once("connect.php");
session_start(); 
$user_id = $_SESSION['user_id']; 
if(isset($_POST['submit']))
{
   $job_title=$_POST['job_title'];
   $schedule_req=$_POST['schedule_req'];
   $location=$_POST['location'];
   $description=$_POST['description'];
   $post_date=$_POST['post_date'];
   $salary=$_POST['salary'];

   /* if (!preg_match('/^[a-zA-Z0-9\s]+$/', $job_title))
    {
        echo "Invalid job title format.";
        exit;
    }
   Duplicate job title check
  $query = "SELECT * FROM jobs WHERE job_title = '$job_title'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
      echo "Job title already exists.";
      exit;
  }*/

  $query = "INSERT INTO `job_posting`(`user_id`, `job_title`,
   `schedule_requirement`, `location`, `description`, `posted_date`, `salary`) VALUES
    ('$user_id','$job_title','$schedule_req','$location','$description','$post_date','$salary')";
   $data=mysqli_query($conn, $query);
   if(!$data)
   {
    echo "error inserting values";
   }
   /*else
   {
    $sql="SELECT `job_post_id`FROM  `job_posting`  WHERE  `user_id`='$user_id'";
    $data2=mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($data2))
     {
        $job_post_id = $row['job_post_id'];
        $_SESSION['job_post_id'] = $job_post_id;  
    } else {
        echo "No job posts found for this user.";
    }
    
   }*/
}
?>