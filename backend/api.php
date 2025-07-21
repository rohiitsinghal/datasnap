<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    // Handle form submission
    $input = json_decode(file_get_contents('php://input'), true);
    
    $name = $input['name'] ?? '';
    $email = $input['email'] ?? '';
    $phone = $input['phone'] ?? '';
    $date_of_birth = $input['date_of_birth'] ?? '';
    $gender = $input['gender'] ?? '';
    
    // Validate input
    if (empty($name) || empty($email) || empty($phone) || empty($date_of_birth) || empty($gender)) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["error" => "Invalid email format"]);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO submissions (name, email, phone, date_of_birth, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $date_of_birth, $gender);
    
    if ($stmt->execute()) {
        // This is the correct success response
        echo json_encode(["success" => true, "message" => "Data submitted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to submit data: " . $stmt->error]);
    }
    
    $stmt->close(); // This was misplaced before
    
} elseif ($method == 'GET') {
    // This is the corrected GET logic
    $result = $conn->query("SELECT * FROM submissions ORDER BY created_at DESC");
    
    $submissions = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $submissions[] = $row;
        } // <- This closing brace was missing
    } // <- This closing brace was missing
    
    echo json_encode(["data" => $submissions]);
}

$conn->close();
?>
