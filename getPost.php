<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// DB connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "vulnerable_gallery"; // change to your actual DB name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

// Ensure the user is logged in by checking the session
if (!isset($_SESSION['email'])) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$userEmail = $_SESSION['email']; // Get the logged-in user's email

// Fetch posts created by the logged-in user
$sql = "SELECT id, title, content, user_email, created_at, username FROM posts WHERE user_email = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail); // Bind the user email to the query
$stmt->execute();

$result = $stmt->get_result();

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode(["status" => "success", "posts" => $posts]);

$conn->close();
?>
