<?php
// change-password.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Connect to database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "vulnerable_gallery";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get data from POST request
$currentPassword = $_POST['currentPassword'] ?? '';
$newPassword = $_POST['newPassword'] ?? '';

// Simulate session user (replace with actual session logic)
session_start();
$userId = $_SESSION['id'] ?? null;  // Using 'id' instead of 'user_id'

if (!$userId) {
    echo json_encode(['message' => 'User not logged in']);
    exit;
}

// Get current password from DB
$stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Compare directly with plain text (⚠️ Not secure - only for testing)
if (!$user || $currentPassword !== $user['password']) {
    echo json_encode(['message' => 'Current password is incorrect']);
    exit;
}

// Update to new password (plain text)
$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
if ($stmt->execute([$newPassword, $userId])) {
    echo json_encode(['message' => 'Password updated successfully']);
} else {
    echo json_encode(['message' => 'Failed to update password']);
}
?>
