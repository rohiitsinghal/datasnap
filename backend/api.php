<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    // Read JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    $name = $input['name'] ?? '';
    $email = $input['email'] ?? '';
    $phone = $input['phone'] ?? '';
    $date_of_birth = $input['date_of_birth'] ?? '';
    $gender = $input['gender'] ?? '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($date_of_birth) || empty($gender)) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["error" => "Invalid email format"]);
        exit;
    }

    // Prepare and execute insertion
    $stmt = $conn->prepare("INSERT INTO submissions (name, email, phone, date_of_birth, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $date_of_birth, $gender);

    if ($stmt->execute()) {
        // Correct success response
        echo json_encode(["success" => true, "message" => "Data submitted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to submit data: " . $stmt->error]);
    }

    $stmt->close();

} elseif ($method == 'GET') {
    // Retrieve data
    $result = $conn->query("SELECT * FROM submissions ORDER BY created_at DESC");

    $submissions = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $submissions[] = $row;
        }
    }

    echo json_encode(["data" => $submissions]);
}

$conn->close();
?>
