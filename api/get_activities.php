<?php
// Include the database connection file
include '../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');

// Get city and weather from the request
$city = $_GET['city'];
$weather = $_GET['weather'];

// Query to get activities based on city and weather
try {
    $stmt = $pdo->prepare("
    SELECT * 
    FROM activities
    WHERE 
        cities LIKE :city AND
        weathers LIKE :weather
");

    $stmt->bindValue(':city', '%"'.$city.'%"%', PDO::PARAM_STR);
    $stmt->bindValue(':weather', '%"'.$weather.'%"%', PDO::PARAM_STR);

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
        $response['body'] = $activities;
    } else {
        $response['status'] = 'success';
        $response['message'] = 'No activities';
    }

    echo json_encode($response);
} catch (PDOException $e) {
    $response = array(
        'status' => 'failure',
        'message' => 'Couldnt fetch activities',
        'body' => null
    );
    echo json_encode($response);
    // You can also log the error for debugging purposes
}
?>
