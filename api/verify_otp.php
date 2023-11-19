<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Get user email and OTP from the request
$email = $_POST['email'];
$otp = $_POST['otp'];
$purpose = $_POST['purpose'];

try {
    // Query to retrieve user data by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'failure', 'message' => 'User not found.']);
    } else {
        // Check if the OTP matches and is not expired
        if ($user['otp'] == $otp && strtotime($user['otp_expiry']) > time()) {
           // Check the purpose and mark the user as verified only for signup
            if ($purpose == "signup") {
                $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'OTP verification successful.']);
                } else {
                    echo json_encode(['status' => 'failure', 'message' => 'Failed to update user verification status.']);
                }
            } else {
                echo json_encode(['status' => 'success', 'message' => 'OTP verification successful.']);
            }
        } 
		else if($user['otp'] != $otp){
            echo json_encode(['status' => 'failure', 'message' => 'OTP does not match']);
        }
		else if(strtotime($user['otp_expiry']) > time()){
            echo json_encode(['status' => 'failure', 'message' => 'OTP has expired']);
        }else{
			 echo json_encode(['status' => 'failure', 'message' => 'OTP verification failed.']);
		}
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failure', 'message' => 'Database error.']);
}
?>
