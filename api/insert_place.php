<?php
// Include the database connection file
include '../../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (previous code)

    // Handle image uploads and get file paths
    $imagePaths = [];
    if (!empty($_FILES['images']['tmp_name'])) {
        $uploadDir = '../../images/'; 
        foreach ($_FILES['images']['tmp_name'] as $tmpName) {
            $imageFileName = uniqid() . '_' . basename($_FILES['images']['name']);
            $imagePath = $uploadDir . $imageFileName;
            move_uploaded_file($tmpName, $imagePath);
            $imagePaths[] = $imagePath;
        }
    }

    // Prepare and execute the SQL query to insert data
    try {
        $stmt = $pdo->prepare("
            INSERT INTO places (name, images, thumbnail, description, html, lat, lang, tags, nearby_places)
            VALUES (:name, :images, :thumbnail, :description, :html, :lat, :lang, :tags, :nearby_places)
        ");

        // ... (bind other parameters)

        $stmt->bindValue(':images', json_encode($imagePaths), PDO::PARAM_STR);

        $stmt->execute();

        // Return success response
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // ... (error handling)
    }
} else {
    // ... (error handling)
}
?>
