<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    max-width: 600px;
    margin: 0 auto;
}

form div {
    margin-bottom: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"], input[type="number"], select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px 15px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
}

.job-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.job-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 300px;
    box-sizing: border-box;
}

.job-card h3 {
    margin: 0 0 10px;
    color: #4CAF50;
}

.job-card p {
    margin: 5px 0;
    color: #555;
}

.job-card p strong {
    color: #000;
}

</style>
</head>
<body>
<form method="post" action="">
    <div>
        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title" placeholder="Enter job title...">
    </div>

    <div>
        <label for="job_type">Job Type:</label>
        <select id="job_type" name="job_type">
            <option value="">--Select Job Type--</option>
            <option value="Retail">Retail</option>
            <option value="Hospitality">Hospitality</option>
            <option value="Education">Education</option>
            <option value="Healthcare">Healthcare</option>
            <option value="Finance">Finance</option>
            <option value="Customer service">Customer Service</option>
        </select>
    </div>

    <div>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" placeholder="Enter location...">
    </div>

    <div>
        <label for="salary_min">Salary Range:</label>
        <input type="number" id="salary_min" name="salary_min" placeholder="Min Salary">
        <input type="number" id="salary_max" name="salary_max" placeholder="Max Salary">
    </div>

    <button name="search" type="submit">Search</button>
</form>
<?php
require_once("connect.php");
session_start();
$user_id=$_SESSION['user_id'];
// Initialize where clause
$whereClauses = [];
if(isset($_POST['search']))
{
// Check for Job Title filter
if (isset($_POST['job_title']) && !empty($_POST['job_title'])) {
    $jobTitle = $conn->real_escape_string($_POST['job_title']);
    $whereClauses[] = "job_title LIKE '%$jobTitle%'";
}

// Check for Job Type filter
if (isset($_POST['job_type']) && !empty($_POST['job_type'])) {
    $jobType = $conn->real_escape_string($_POST['job_type']);
    $whereClauses[] = "job_type = '$jobType'";
}

// Check for Location filter
if (isset($_POST['location']) && !empty($_POST['location'])) {
    $location = $conn->real_escape_string($_POST['location']);
    $whereClauses[] = "location LIKE '%$location%'";
}

// Check for Salary Range filter
if (isset($_POST['salary_min']) && isset($_POST['salary_max']) && !empty($_POST['salary_min']) && !empty($_GET['salary_max'])) {
    $salaryMin = (int)$_POST['salary_min'];
    $salaryMax = (int)$_POST['salary_max'];
    $whereClauses[] = "salary BETWEEN $salaryMin AND $salaryMax";
}

// Add default conditions for active and non-expired jobs
$whereClauses[] = "status = true";
$whereClauses[] = "admin_status = true";
$whereClauses[] = "posted_date >= CURDATE()";

// Combine all where clauses into a single string
$whereClause = implode(' AND ', $whereClauses);

// SQL query to fetch matching job postings
$sql = "SELECT job_post_id,user_id, job_title, description, location, salary, posted_date 
        FROM job_posting 
        WHERE $whereClause 
        ORDER BY posted_date DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Job Results:</h2>";
    echo "<div class='job-container'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='job-card'>
                <h3>" . htmlspecialchars($row['job_title']) . "</h3>
                <p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>
                <p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>
                <p><strong>Salary:</strong> $" . htmlspecialchars($row['salary']) . "</p>
                <p><strong>Posted Date:</strong> " . htmlspecialchars($row['posted_date']) . "</p>";
                echo "<form action='' method='POST'>";
                echo "<input type='hidden' name='job_post_id' value='" . $row['job_post_id'] . "'>";
                echo "<input type='hidden' name='user_id' value='" . $row['user_id'] . "'>";
                echo "<button type='submit' name='apply'>Apply Now</button>";
                 echo "</form>";
          echo"</div>";
          if(isset($_POST['apply']))
          {
            $provider_id=$_POST['user_id'];
            $post_id=$_POST['job_post_id'];
            session_start();
            $_SESSION['job_id']=$post_id;
            $_SESSION['provider_id']=$provider_id;
            header('Location: ../job-apply.php');
          }
    }
    echo "</div>";
} else {
    echo "<p>No matching jobs found.</p>";
}
}
?>


</body>
</html>