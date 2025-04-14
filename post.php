<?php
// Database connection settings
$host = 'localhost'; // Your host
$dbname = 'blog_db'; // Your database name
$username = 'root'; // Default MySQL username for XAMPP
$password = ''; // Default MySQL password for XAMPP (empty by default)

try {
    // Create a PDO instance for MySQL connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $title = htmlspecialchars($_POST['post-title']);
        $content = htmlspecialchars($_POST['post-content']);
        
        // Prepare SQL query to insert data into the posts table
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Post created successfully!";
        } else {
            echo "Failed to create post.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h1>Create New Post</h1>
    <form id="post-form" class="space-y-4" method="POST">
        <div>
            <label for="post-title" class="block text-sm font-medium text-gray-700">Post Title</label>
            <input type="text" id="post-title" name="post-title"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
        </div>
        <div>
            <label for="post-content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea id="post-content" name="post-content" rows="5"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Create Post</button>
    </form>
</body>
</html>