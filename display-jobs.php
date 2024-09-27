<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

 
 require_once("connect.php");
 session_start();
 $user_id=$_SESSION['user_id'];
$sql="SELECT * FROM job_posting ";
$data=mysqli_query($conn,$sql);
if(mysqli_num_rows($data)>0)
{
    while($row=mysqli_fetch_array($data))
    {
        
    }
}
 ?>   
</body>
</html>-->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .job-card {
     width:50%;
     border-radius:10px;
      border: 1px solid #ddd;
      padding: 20px;
      margin: 20px  300px;
      box-shadow: 0 0 10px black;
    }
  </style>
</head>
<body>
<?php 
    require_once("connect.php"); 
    session_start(); 
    $user_id = 12; //$_SESSION['user_id'];
    $sql = "SELECT * FROM job_posting";
    $data = mysqli_query($conn, $sql);
  ?>
  
  <?php if(mysqli_num_rows($data) > 0) { ?>
    <?php while($row = mysqli_fetch_array($data)) { ?>
      <div class="job-card">
        <h2><?php echo $row['job_title']; ?></h2>
        <p>Schedule requirement: <?php echo $row['schedule_requirement']; ?></p>
        <p>Posted on: <?php echo $row['posted_date']; ?></p>
        <form action="" method=post>
        <input type="hidden" name="post_id" value="<?php echo $row['job_post_id']; ?>">
        <button type=submit name=details>View Details</button>
      </div>
    <?php } ?>
  <?php } else { ?>
    <p>No job postings found.</p>
  <?php } ?>
  <?php 
   if(isset($_POST['details']))
   {
    $post_id=$_POST['job_post_id'];
    $sql="SELECT * FROM job_posting WHERE `job_post_id`='$post_id'";
    
   }
</body>
</html>
