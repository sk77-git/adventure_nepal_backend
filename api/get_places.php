<?php
// Include the database connection file
include '../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');

// Get user's current latitude and longitude from the request (you'll get this from the Flutter app)
$currentLat = floatval($_GET['lat']);
$currentLang = floatval($_GET['long']);

// Get tags from the request (if available)
$tags = isset($_GET['tags']) ? json_decode($_GET['tags']) : [];

// Query to get nearby places based on current location and filter by tags
try {
    $stmt = $pdo->prepare("
    SELECT * 
    FROM places
    WHERE 
        ( 
            lat BETWEEN :minLat AND :maxLat AND
            lang BETWEEN :minLang AND :maxLang
        )
");

$minLat = $currentLat - 1.0;
$maxLat = $currentLat + 1.0;
$minLang = $currentLang - 1.0;
$maxLang = $currentLang + 1.0;

$stmt->bindValue(':minLat', $minLat, PDO::PARAM_STR);
$stmt->bindValue(':maxLat', $maxLat, PDO::PARAM_STR);
$stmt->bindValue(':minLang', $minLang, PDO::PARAM_STR);
$stmt->bindValue(':maxLang', $maxLang, PDO::PARAM_STR);

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
    $response['status'] = 'success';
    $response['message'] = 'Fetched places';
    $response['body']=$places;
    echo json_encode($response);
} else {
    $response['status'] = 'success';
    $response['message'] = 'No places';
    $response['body']=[];
    echo json_encode($response);
}
// Return the places data as JSON
//echo json_encode($places);
} catch (PDOException $e) {
    $response['status'] = 'failure';
    $response['message'] = 'Something went wrong';
    $response['body']=NULL;
    echo json_encode($response);
    // You can also log the error for debugging purposes
}
