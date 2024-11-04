
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .job-card {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  width: 50%;
  margin: 20px 300px;
  transition: all 0.3s ease;
}
    /*.job-card {
     width:50%;
     border-radius:10px;
      border: 1px solid #ddd;
      padding: 20px;
      margin: 20px  300px;
      box-shadow: 0 0 10px black;
    }*/
    button[type="submit"] {
    width: 50%;
    padding: 10px;
    background-color: #101111;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
    .dashboard-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

        

.job-card:hover {
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  transform: translateY(-5px);
}

  </style>
</head>
<body>
<?php 
    require_once("connect.php"); 
    session_start(); 
    $sql = "SELECT * FROM job_posting WHERE `admin_status`=";
    $data = mysqli_query($conn, $sql);
  ?>
  
  <?php if(mysqli_num_rows($data) > 0) { ?>
    <?php while($row = mysqli_fetch_array($data)) { ?>
      <div class="job-card">
        <h2><?php echo $row['job_title']; ?></h2>
        <p>Schedule requirement: <?php echo $row['schedule_requirement']; ?></p>
        <p>Location: <?php echo $row['location']; ?></p>
        <p>Description: <?php echo $row['description'];?></p>
        <p>Salary: <?php echo $row['salary'];?> </p>
        <p>Contact no: <?php echo $row['contact_no'];?> </p>
        <p>Posted on: <?php echo $row['posted_date']; ?></p>
        <form action="" method=post>
        <input type="hidden" name="post_id" value="<?php echo $row['job_post_id']; ?>">
        <input type="hidden" name="provider_id" value="<?php echo $row['user_id']; ?>">
        <button type=submit name=apply>Apply</button>
       </form>
      </div>
    <?php } ?>
  <?php } else { ?>
    <p>No job postings found.</p>
  <?php } ?>
  <?php 
    if(isset($_POST['apply']))
      {
        $provider_id=$_POST['provider_id'];
        $post_id=$_POST['post_id'];
        $_SESSION['job_id']=$post_id;
        $_SESSION['provider_id']=$provider_id;
        header('Location: job-apply.php');
      }
     ?>
</body>
</html>
