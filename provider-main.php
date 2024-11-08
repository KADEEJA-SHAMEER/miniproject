<?php
    require_once("connect.php");
    session_start();

    // Retrieve the user ID from session
    $user_id = $_SESSION['user_id'];

    // Query to count the total jobs posted by the user
    $sql = "SELECT COUNT(*) AS total_jobs_posted
            FROM job_posting
            WHERE user_id = '$user_id'";
    $data = mysqli_query($conn, $sql);

    // Fetch the result
    $result = mysqli_fetch_assoc($data);
    $total_jobs_posted = $result['total_jobs_posted'];
    
    $sql = "SELECT COUNT(*) AS total_applicants
            FROM job_application
            WHERE `provider_id` = '$user_id'";
    $data = mysqli_query($conn, $sql);

    // Fetch the result
    $result = mysqli_fetch_assoc($data);
    $total_applicants = $result['total_applicants'];

    $sql = "
        SELECT jp.job_title, COUNT(ja.job_apply_id) AS applicant_count
        FROM job_posting jp
        LEFT JOIN job_application ja ON jp.job_post_id = ja.job_post_id
        WHERE jp.user_id = '$user_id'
        GROUP BY jp.job_post_id;
    ";
    $data1 = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Posting Count</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            gap: 20px;
            margin: 0;
        }
        .dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
            max-width: 800px;
            padding: 20px;
        }
        .cards {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            width: 100%;
            max-width: 600px;
        }
        .card {
            width: 300px;
            padding: 20px;
            margin: 20px auto;
            background-color: #f5f5f5;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .card h2 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }
        .card p {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .table-container {
            width: 80%;
            max-width: 600px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-container h2 {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: #fff;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="cards">
<div class="card">
    <h2>Total Jobs Posted</h2>
    <p><?php echo $total_jobs_posted; ?></p>
</div>
<div class="card">
    <h2>Total Applicants</h2>
    <p><?php echo $total_applicants; ?></p>
</div>
    </div>
<div class="table-container">
    <h2>Jobs and Applicant Counts</h2>
    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Total Applicants</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($data1)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                    <td><?php echo $row['applicant_count']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
            </div>
</body>
</html>
