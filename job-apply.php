<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style-jobapplication.css">
</head>
<body>
    
     <form action="job-application.php" method="post">
        <h1>APPLICATION FORM</h1>
        <h4>Details about job</h4>
        <?php
        require_once("connect.php");
    session_start();
    $post_id=$_SESSION['job_id'];
     $sql = "SELECT * FROM job_posting WHERE job_post_id='$post_id'";
     $data = mysqli_query($conn, $sql);
     if($data)
     {
        $row = mysqli_fetch_array($data);?>
        <h2><?php echo $row['job_title']; ?></h2>
        <p>Schedule requirement: <?php echo $row['schedule_requirement']; ?></p>
        <p>Location: <?php echo $row['location']; ?></p>
        <p> Description: <?php echo $row['description'];?></p>
        <p> Salary: <?php echo $row['salary'];?> </p>
        <p>Posted on: <?php echo $row['posted_date']; ?></p>
    <?php }
    ?>
       <h4>Apply for this job</h4>
        <label>Enter about your working experience in this field or any other field: </label><br>
        <textarea name="experience" rows="5" cols="50" placeholder="Enter here" required></textarea><br>
        <label>Enter the apply date:</label><br>
        <input type="date" name="apply_date" required><br>
        <label>about your time availability: </label><br>
        <textarea name="availability" rows="5" cols="50" placeholder="Enter here " required></textarea><br>
        <input type="hidden" name="application_status" value="Pending">
        <button type="submit" name="apply" >APPLY</button>
     </form>
</body>
</html>