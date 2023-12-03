<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Get user id and interests from the request
$userId = $_POST['id'];
$interests = $_POST['interests'];

try {
    // Check if the received array is empty
    if (empty($interests)) {
        echo json_encode(['status' => 'failure', 'message' => 'Received interests array is empty.']);
    } else {
        // Encode interests to JSON
        $encodedInterests = $interests;

        // Check if the user exists
        $userStmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $userStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $userStmt->execute();
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(['status' => 'failure', 'message' => 'User not found.']);
        } else {
            // Update user interests
            $updateStmt = $pdo->prepare("UPDATE users SET categories = :categories WHERE id = :user_id");
            $updateStmt->bindParam(':categories', $encodedInterests, PDO::PARAM_STR);
            $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'User interests updated successfully.']);
            } else {
                echo json_encode(['status' => 'failure', 'message' => 'Failed to update user interests.']);
            }
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failure', 'message' => 'Database error.']);
}
?>
