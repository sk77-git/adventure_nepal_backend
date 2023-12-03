<?php
// Include the database connection file
include '../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');

// Get the search query from the request
$searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

// Query to search for places based on the entered place name
try {
    $stmt = $pdo->prepare("
    SELECT * 
    FROM places
    WHERE 
        name LIKE :searchQuery
    ");

    $searchParam = '%' . $searchQuery . '%';
    $stmt->bindValue(':searchQuery', $searchParam, PDO::PARAM_STR);

    $stmt->execute();
    $places = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize response fields
    $response = array(
        'status' => 'success',
        'message' => '',
        'body' => array()
    );

    // Check if any places were found
    if (count($places) > 0) {
        $response['message'] = 'Fetched places based on search query';
        $response['body'] = $places;
    } else {
        $response['message'] = 'No places found based on the search query';
    }

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(array('status' => 'failure', 'message' => $e, 'body' => null));
    // You can also log the error for debugging purposes
}
?>
