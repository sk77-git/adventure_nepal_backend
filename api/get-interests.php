<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Get user id from the request
$userId = $_GET['user_id'];

try {
    // Query to retrieve user interests by userId
    $stmt = $pdo->prepare("SELECT interests FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userInterests = json_decode($user['interests']);
        echo json_encode(['status' => 'success', 'message' => 'User interests fetched successfully.', 'interests' => $userInterests]);
    } else {
        echo json_encode(['status' => 'failure', 'message' => 'User not found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failure', 'message' => 'Database error.']);
}
?>
