<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="search.css">
</head>
<body>
    <?php
    require_once("connect.php");
$job_type="Retail";
// Query to fetch job postings based on the selected job type
$sql = "SELECT * FROM job_posting WHERE `job_type` ='$job_type' AND status = 1"; // Only show active jobs
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $job_type); // Bind the job_type parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Loop through the results and display each job posting
    echo "<h2>Job Postings for '$job_type' Type</h2>";
    echo "<div class='job-listing'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='job-item'>";
        echo "<h3>" . htmlspecialchars($row['job_title']) . "</h3>";
        echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
        echo "<p><strong>Schedule type:</strong> " . htmlspecialchars($row['schedule_type']) . "</p>";
        echo "<p><strong>Schedule Requirement:</strong> " . htmlspecialchars($row['schedule_requirement']) . "</p>";  
        echo "<p><strong>Description:</strong> " . nl2br(htmlspecialchars($row['description'])) . "</p>";
        echo "<p><strong>Salary:</strong> $" . number_format($row['salary']) . "</p>";
        echo "<p><strong>Contact:</strong> " . htmlspecialchars($row['contact_no']) . "</p>";
        echo "<p><strong>Posted on:</strong> " . $row['posted_date'] . "</p>";
        echo "<a href='apply.php?job_post_id=" . $row['job_post_id'] . "'>Apply Now</a>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No job postings found for this job type.</p>";
}

$stmt->close();
$conn->close();
?>

</body>
</html>