<?php
 require_once("connect.php");
 if(isset($_POST['update']))
   {
    $post_id=$_POST['post_id'];
    $job_title=$_POST['jobtitle'];
    $schedule_type=$_POST['schedule_type'];
    $job_type=$_POST['job_type'];
    $contact=$_POST['contact_no'];
    $schedule_req=$_POST['schedule_req'];
    $location=$_POST['location'];
    $description=$_POST['description'];
    $post_date=$_POST['post_date'];
    $exp_date=$_POST['exp_date'];
    $salary=$_POST['salary'];
    $sql="UPDATE `job_posting` SET `job_title`='$job_title',
    `contact_no`='$contact',`schedule_type`='$schedule_type',`job_type`='$job_type',`schedule_requirement`='$schedule_req',
    `location`='$location',`description`='$description',`posted_date`='$post_date',`exp_date`='$exp_date',`salary`='$salary' WHERE  `job_post_id`='$post_id'";
     if($conn->query($sql)===FALSE){
      die("error updating value: ".$conn->error);
  }else
  {
    header('Location: display-jobpost.php');
  }
   }
   ?>