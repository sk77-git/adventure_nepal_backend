<?php
// Include the database connection file
include '../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');



// Query to get nearby activities based on current location and filter criteria
try {
    $stmt = $pdo->prepare("
    SELECT * 
    FROM activities
");


$stmt->execute();
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
$response = array(
    'status' => 'success',
    'message' => '',
    'body' => array()
);
// Check if any activities were found
if (count($activities) > 0) {
    $response['status'] = 'success';
    $response['message'] = 'Fetched activities';
    $response['body']=$activities;
    echo json_encode($response);
} else {
    $response['status'] = 'success';
    $response['message'] = 'No activities';
    $response['body']=[];
    echo json_encode($response);
}
} catch (PDOException $e) {
    $response['status'] = 'failure';
    $response['message'] = 'Couldnt fetch activities';
    $response['body']=NULL;
    echo json_encode($response);
    // You can also log the error for debugging purposes
}
?>
