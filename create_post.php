<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // for development only
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Connect to DB
$host = "localhost";
$username = "root";
$password = "";
$dbname = "vulnerable_gallery"; // replace this with your DB name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

$title = $conn->real_escape_string($data['title']);
$content = $conn->real_escape_string($data['content']);
$email = $conn->real_escape_string($data['email']);
$username = $conn->real_escape_string($data['username']); // get user from JS

// Insert into DB
$sql = "INSERT INTO posts (title, content, user_email,username) VALUES ('$title', '$content', '$email','$username')"; // assuming username is same as email for simplicity
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Post created"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to create post"]);
}

$conn->close();
?>
