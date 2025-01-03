
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        .dashboard-cards, .category-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
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

        .divider {
            border: none;
            border-top: 2px solid #ddd;
            margin: 30px 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            .dashboard-cards, .category-cards {
                display: block;
            }

            .card {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
<?php
    require_once("connect.php");

    // Fetch counts with alias
    $user_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE user_status = 1")->fetch_assoc()['total'];
    $job_post_count = $conn->query("SELECT COUNT(*) AS total FROM job_posting WHERE `status` = true")->fetch_assoc()['total'];
    $job_application_count = $conn->query("SELECT COUNT(*) AS total FROM job_application WHERE `status` = true")->fetch_assoc()['total'];

    // Error handling (optional)
    if (!$user_count || !$job_post_count || !$job_application_count) {
        die("Error fetching data: " . $conn->error);
    }
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
    </div>

    <hr class="divider">

    <h2>Jobs Available on Different Categories</h2>
    <div class="category-cards">
        <?php
        // Query to count jobs by category
        $query = "SELECT job_type, COUNT(*) AS count FROM job_posting WHERE status = true GROUP BY job_type";
        $result = $conn->query($query);

        if ($result->num_rows == 0) {
            echo "<p>No job postings found.</p>";
        } else {
            while ($row = $result->fetch_assoc()) { ?>
                <div class="card">
                    <h2><?php echo $row['job_type']; ?></h2>
                    <p><?php echo $row['count']; ?> jobs available</p>
                </div>
        <?php } 
        }
        ?>
    </div>
</body>
</html>
      