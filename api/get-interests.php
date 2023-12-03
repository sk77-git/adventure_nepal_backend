<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

try {
    // Query to retrieve user interests by userId
    $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

    if ($userId) {
        $stmtUser = $pdo->prepare("SELECT categories FROM users WHERE id = :user_id");
        $stmtUser->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userInterests = json_decode($user['categories']);
        } else {
            echo json_encode(['status' => 'failure', 'message' => 'User not found.']);
            exit();
        }
    } else {
        $userInterests = [];
    }

    // Query to retrieve all categories
    $stmtAllCategories = $pdo->prepare("SELECT * FROM categories");
    $stmtAllCategories->execute();
    $allCategories = $stmtAllCategories->fetchAll(PDO::FETCH_ASSOC);

    // Response
    $response = [
        'status' => 'success',
        'message' => 'Categories fetched successfully.',
        'user_categories' => $userInterests,
        'all_categories' => $allCategories
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['status' => 'failure', 'message' => 'Database error.']);
}
?>
