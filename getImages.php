<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$username = "root";
$password = "";
$dbname = "vulnerable_gallery"; // replace with your DB name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit();
}

$sql = "SELECT title, filename, username, uploaded_at FROM images ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = $row;
}

echo json_encode(["status" => "success", "images" => $images]);

$conn->close();
?>
