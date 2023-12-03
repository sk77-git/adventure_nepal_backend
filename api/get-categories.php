<?php
// Include the database connection file
include '../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');

// Query to get all categories from the categories table
try {
    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize response fields
    $response = array(
        'status' => 'success',
        'message' => 'Fetched all categories',
        'body' => $categories
    );

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(array('status' => 'failure', 'message' => $e, 'body' => null));
    // You can also log the error for debugging purposes
}
?>
