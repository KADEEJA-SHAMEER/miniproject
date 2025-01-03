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

    <button type="submit">Search</button>
</form>
<?php
// Database connection
$conn = new mysqli("localhost", "username", "password", "database_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize where clause
$whereClauses = [];

// Check for Job Title filter
if (isset($_GET['job_title']) && !empty($_GET['job_title'])) {
    $jobTitle = $conn->real_escape_string($_GET['job_title']);
    $whereClauses[] = "job_title LIKE '%$jobTitle%'";
}

// Check for Job Type filter
if (isset($_GET['job_type']) && !empty($_GET['job_type'])) {
    $jobType = $conn->real_escape_string($_GET['job_type']);
    $whereClauses[] = "job_type = '$jobType'";
}

// Check for Location filter
if (isset($_GET['location']) && !empty($_GET['location'])) {
    $location = $conn->real_escape_string($_GET['location']);
    $whereClauses[] = "location LIKE '%$location%'";
}

// Check for Salary Range filter
if (isset($_GET['salary_min']) && isset($_GET['salary_max']) && !empty($_GET['salary_min']) && !empty($_GET['salary_max'])) {
    $salaryMin = (int)$_GET['salary_min'];
    $salaryMax = (int)$_GET['salary_max'];
    $whereClauses[] = "salary BETWEEN $salaryMin AND $salaryMax";
}

// Add default conditions for active and non-expired jobs
$whereClauses[] = "status = true";
$whereClauses[] = "admin_status = true";
$whereClauses[] = "posted_date >= CURDATE()";

// Combine all where clauses into a single string
$whereClause = implode(' AND ', $whereClauses);

// SQL query to fetch matching job postings
$sql = "SELECT job_title, description, location, salary, posted_date 
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
                <p><strong>Posted Date:</strong> " . htmlspecialchars($row['posted_date']) . "</p>
              </div>";
    }
    echo "</div>";
} else {
    echo "<p>No matching jobs found.</p>";
}
?>


</body>
</html>