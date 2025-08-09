<?php
// Enable error reporting for development/debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set required headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection settings -- update these with your real credentials
$servername = "localhost";  // or your hosting provider's DB host
$username = "root";         // your DB username
$password = "";             // your DB password
$dbname = "datasnap_db";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Output JSON error and stop script
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}
?>
