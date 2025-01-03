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

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
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
require_once("connect.php");

// Initialize where clause
$whereClauses = [];

// Check for Job Title filter
if (isset($_POST['job_title']) && !empty($_POST['job_title'])) {
    $jobTitle = $conn->real_escape_string($_POST['job_title']);
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
    echo "<table border='1'>
            <tr>
                <th>Job Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Salary</th>
                <th>Posted Date</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['job_title']) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>
                <td>" . htmlspecialchars($row['location']) . "</td>
                <td>" . htmlspecialchars($row['salary']) . "</td>
                <td>" . htmlspecialchars($row['posted_date']) . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No matching jobs found.</p>";
}
?>

</body>
</html>