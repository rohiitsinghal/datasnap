<?php
require_once 'config.php';

echo "<h3>Database Connection Test</h3>";
echo "Connected to database: " . ($conn ? "YES" : "NO") . "<br>";

echo "<h3>Table Exists Check</h3>";
$table_check = $conn->query("SHOW TABLES LIKE 'submissions'");
echo "Table 'submissions' exists: " . ($table_check->num_rows > 0 ? "YES" : "NO") . "<br>";

echo "<h3>Record Count</h3>";
$count_result = $conn->query("SELECT COUNT(*) as total FROM submissions");
if ($count_result) {
    $count_row = $count_result->fetch_assoc();
    echo "Total records: " . $count_row['total'] . "<br>";
} else {
    echo "Error counting records: " . $conn->error . "<br>";
}

echo "<h3>Sample Records</h3>";
$result = $conn->query("SELECT * FROM submissions ORDER BY created_at DESC LIMIT 5");
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Record: " . json_encode($row) . "<br>";
    }
} else {
    echo "No records found or error: " . $conn->error . "<br>";
}

$conn->close();
?>
