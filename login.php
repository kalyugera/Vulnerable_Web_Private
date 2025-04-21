<?php
// CORS headers (must be at the very top before any output)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight request (for OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "vulnerable_gallery";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data safely
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Basic SQL injection protection (for real apps, use prepared statements)
$email = $conn->real_escape_string($email);
$password = $conn->real_escape_string($password);

// Fetch user
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    session_start();
    $user = $result->fetch_assoc();
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    
    echo json_encode(['status' => 'success','email' => $user['email'],'username' => $user['username'],'id' => $user['id']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
}

$conn->close();
?>
