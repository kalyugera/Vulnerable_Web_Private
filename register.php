<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "vulnerable_gallery";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['register-username'];
$email = $_POST['register-email'];
$password = $_POST['register-password']; // Stored in plain text - vulnerable!

$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful. <a href='index.html'>Login Now</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
