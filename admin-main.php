<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .dashboard-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
.category-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.category-cards .card {
  margin: 20px;
}

   
.card {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  width: 250px;
  margin: 20px;
  transition: all 0.3s ease;
}

.card:hover {
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  transform: translateY(-5px);
}

.card h2 {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 10px;
}

.card p {
  font-size: 14px;
  color: #666;
}

@media (max-width: 768px) {
  .card {
    width: 100%;
    margin: 20px 0;
  }
}

@media (max-width: 480px) {
  .card {
    padding: 10px;
  }
}
.divider {
  border: black;
  border-top: 1px solid #ccc;
  margin: 20px 0;
}

</style>
</head>
<body>
    <?php
    require_once("connect.php");
    $user_count = $conn->query("SELECT COUNT(*) FROM users")->fetch_assoc()['COUNT(*)'];

// Count job posts
$job_post_count = $conn->query("SELECT COUNT(*) FROM job_posting")->fetch_assoc()['COUNT(*)'];

// Count job applications
$job_application_count = $conn->query("SELECT COUNT(*) FROM job_application")->fetch_assoc()['COUNT(*)'];




// Display counts in admin dashboard
?>

<div class="dashboard-cards">
  <div class="card">
    <h2>Users</h2>
    <p><?php echo $user_count; ?></p>
  </div>
  <div class="card">
    <h2>Job Posts</h2>
    <p><?php echo $job_post_count; ?></p>
  </div>
  <div class="card">
    <h2>Job Applications</h2>
    <p><?php echo $job_application_count; ?></p>
  </div>
  <hr class="divider">
  <h2>JOBS AVAILABLE ON DIFFERENT CATEGORIES</h2>
  <div class="category-cards">
    <?php
    $query = "SELECT job_type, COUNT(*) as count FROM job_posting GROUP BY job_type";
    $result = $conn->query($query);
    
    if ($result->num_rows == 0) {
      echo "No job postings found.";
      // or display 0 for each category
      $categories = array('Retail', 'Hospitality', 'Education', 'Healthcare', 'Finance', 'Customer Service');
      foreach ($categories as $category) {
          echo "$category: 0";
      }
    } else {
      $job_category_counts = array();
      while ($row = $result->fetch_assoc()) {
          $job_category_counts[$row['job_type']] = $row['count'];
      }
    
     foreach ($job_category_counts as $category => $count) { ?>
      <div class="card">
        <h2><?php echo $category; ?></h2>
        <p><?php echo $count; ?></p>
      </div>
    <?php } ?>
    <?php }?>
  </div>
</div>


</body>
</html>