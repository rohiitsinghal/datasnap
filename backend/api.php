<?php
require_once 'config.php';
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);

    $name = $input['name'] ?? '';
    $email = $input['email'] ?? '';
    $phone = $input['phone'] ?? '';
    $date_of_birth = $input['date_of_birth'] ?? '';
    $gender = $input['gender'] ?? '';

    if(empty($name) || empty($email) || empty($phone) || empty($date_of_birth) || empty($gender)){
        echo json_encode(["error" => "All fields are required."]);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo json_encode(["error" => "Invalid email format."]);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO submissions (name, email, phone, date_of_birth, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss" , $name, $email, $phone, $date_of_birth, $gender);
    if($stmt->execute()){
        echo json_encode(["success" => "Submission successful."]);
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }
    $stmt->close();
}elseif ($method == 'GET'){
    $result = $conn->query("SELECT * FROM submissions ORDER BY created_at DESC");
    $submissions = [];
    if($result->num_rows > 0){
        while($ro = $result->fetch_assoc()){
            $submission[]=$row;
        }
    }
    echo json_encode(["data" => $submissions]);
}
$conn->close();
?>