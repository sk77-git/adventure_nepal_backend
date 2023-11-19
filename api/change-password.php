<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Get user email and new password from the request
$email = $_POST['email'];
$newPassword = $_POST['new_password'];

try {
    // Query to retrieve user data by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'failure', 'message' => 'User not found.']);
    } else {
        // Update the user's password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
        } else {
            echo json_encode(['status' => 'failure', 'message' => 'Failed to update password.']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failure', 'message' => 'Database error.']);
}
?>
