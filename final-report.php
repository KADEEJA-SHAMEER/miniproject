<?php
require_once("connect.php");

$timeRangeText = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reportType = $_POST['report_type'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    
    $whereClause = "";
    
    if ($reportType == "yearly") {
        $whereClause = "YEAR(posted_date) = YEAR(CURDATE())";
        $timeRangeText = "Year: " . date("Y");
    } elseif ($reportType == "monthly") {
        $whereClause = "MONTH(posted_date) = MONTH(CURDATE()) AND YEAR(posted_date) = YEAR(CURDATE())";
        $timeRangeText = "Month: " . date("F Y");
    } elseif ($reportType == "custom") {
        $whereClause = "posted_date BETWEEN '$startDate' AND '$endDate'";
        $timeRangeText = "From: " . date("Y-m-d", strtotime($startDate)) . " To: " . date("Y-m-d", strtotime($endDate));
    }
    
    // SQL query to get job postings count
    $jobPostingQuery = "SELECT COUNT(*) as total_jobs FROM job_posting WHERE $whereClause";
    $result1 = $conn->query($jobPostingQuery);
    $jobPostingCount = $result1->fetch_assoc()['total_jobs'];
    
    // SQL query to get applications count, accepted, and rejected counts
    $jobApplicationQuery = "SELECT 
    COUNT(*) as total_applications, 
    SUM(CASE WHEN application_status = 'approved' THEN 1 ELSE 0 END) as accepted_count,
    SUM(CASE WHEN application_status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
    SUM(CASE WHEN application_status = 'pending' THEN 1 ELSE 0 END) as pending_count
FROM job_application
JOIN job_posting ON job_application.job_post_id = job_posting.job_post_id
WHERE $whereClause";

    $result2 = $conn->query($jobApplicationQuery);
    $applicationData = $result2->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Posting Report</title>
    <style>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Posting Report</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }

        h2, h3 {
            color: #4CAF50;
        }

        /* Form styling */
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 300px;
            text-align: left;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        select, input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Table styling */
        table {
            width: 80%;
            max-width: 600px;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <!-- Content goes here -->
    <h2>Job Posting and Application Report</h2>
    <form method="POST" action="">
        <label for="report_type">Select Report Type:</label>
        <select name="report_type" id="report_type" required>
            <option value="yearly">Yearly</option>
            <option value="monthly">Monthly</option>
            <option value="custom">Custom Date Range</option>
        </select><br><br>
        
        <div id="custom_dates" style="display: none;">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date"><br><br>
        </div>
        
        <input type="submit" value="Generate Report">
    </form>

    <?php if (isset($jobPostingCount)) { ?>
        <h3>Report Results for <?php echo $timeRangeText; ?></h3>
        <table border="1">
            <tr>
                <th>Total Job Postings</th>
                <th>Total Applications</th>
                <th>Accepted Applications</th>
                <th>Rejected Applications</th>
                <th>Pending Applications</th>
            </tr>
            <tr>
                <td><?php echo $jobPostingCount; ?></td>
                <td><?php echo $applicationData['total_applications']; ?></td>
                <td><?php echo $applicationData['accepted_count']; ?></td>
                <td><?php echo $applicationData['rejected_count']; ?></td>
                <td><?php echo $applicationData['pending_count']; ?></td>
            </tr>
        </table>
    <?php } ?>

    <script>
        // Show or hide date fields based on report type selection
        document.getElementById('report_type').addEventListener('change', function() {
            if (this.value === 'custom') {
                document.getElementById('custom_dates').style.display = 'block';
            } else {
                document.getElementById('custom_dates').style.display = 'none';
            }
        });
    </script>
</body>
</html>
