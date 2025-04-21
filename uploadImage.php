<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

$host = "localhost";
$username = "root";
$password = "";
$dbname = "vulnerable_gallery"; // update this!

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit();
}

// Check if image file and metadata are sent
if (!isset($_FILES['image']) || !isset($_POST['title']) || !isset($_POST['email']) || !isset($_POST['username'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit();
}

$title = $conn->real_escape_string($_POST['title']);
$email = $conn->real_escape_string($_POST['email']);
$username = $conn->real_escape_string($_POST['username']);

// Handle file upload
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir);
}

$filename = basename($_FILES["image"]["name"]);
$targetPath = $uploadDir . uniqid() . "_" . $filename;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
    $sql = "INSERT INTO images (title, filename, user_email, username) 
            VALUES ('$title', '$targetPath', '$email', '$username')";
    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Image uploaded"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "DB insert failed"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Image upload failed"]);
}

$conn->close();
?>
