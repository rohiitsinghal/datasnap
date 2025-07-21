<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Read database credentials from Render's environment variables
$servername = "sql106.infinityfree.com";
$username = "if0_39523934";
$password = "monerosa123";
$dbname = "if0_39523934_datasnap_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}
?>
