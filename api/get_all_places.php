<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Initialize response fields
$response = array(
    'status' => 'success',
    'message' => '',
    'body' => array()
);

// Query to get all places
try {
    $stmt = $pdo->prepare("SELECT * FROM places");
    $stmt->execute();
    $places = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set the body field with places data
    $response['body'] = $places;
} catch (PDOException $e) {
    // Set error status and message
    $response['status'] = 'error';
    $response['message'] = 'Failed to fetch places';
    // You can also log the error for debugging purposes
}

// Return the response as JSON
echo json_encode($response, JSON_PRETTY_PRINT);
?>
