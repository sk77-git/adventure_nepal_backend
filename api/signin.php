<?php
// Include the database connection file
include '../includes/db_connection.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer autoloader
require 'C:\xampp\htdocs\adv_nepal\api\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\adv_nepal\api\phpmailer\src\SMTP.php';
require 'C:\xampp\htdocs\adv_nepal\api\phpmailer\src\Exception.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Get user email and password from the request
$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Query to retrieve user data by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'failure', 'message' => 'User not found.']);
    } else {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Check if the user is verified
            if ($user['is_verified'] == 1) {
                echo json_encode(['status' => 'success','is_verified' => true, 'message' => 'Login successful.']);
            } else {
                // User is not verified, send OTP for verification
                $otp = generateOTP();
                $otpExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Update OTP and OTP expiry in the database
                $stmt = $pdo->prepare("UPDATE users SET otp = :otp, otp_expiry = :otp_expiry WHERE email = :email");
                $stmt->bindParam(':otp', $otp, PDO::PARAM_INT);
                $stmt->bindParam(':otp_expiry', $otpExpiry, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    // Send the OTP to the user's email using PHPMailer
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output (0 for production)
                        $mail->isSMTP();                           // Set mailer to use SMTP
                        $mail->Host = 'smtp.gmail.com';          // Specify SMTP server
                        $mail->SMTPAuth = true;                    // Enable SMTP authentication
                        $mail->Username = 'shrawankumarthakur77@gmail.com'; // SMTP username
                        $mail->Password = 'slsq lnqb gdwl ouuj';          // SMTP password
                        $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = 587;                         // TCP port to connect to
                        // Recipients
                        $mail->setFrom('your_email@example.com', 'Adventure Nepal');
                        $mail->addAddress($email);                 // Add a recipient

                        // Content
                        $mail->isHTML(true);                       // Set email format to HTML
                        $mail->Subject = 'Verification OTP';
                        $mail->Body    = 'Your OTP for verification is: ' . $otp;

                        $mail->send();

                        echo json_encode(['status' => 'success','is_verified' => false, 'message' => 'User not verified. OTP sent to your email.']);
                    } catch (Exception $e) {
                        echo json_encode(['status' => 'failure','is_verified' => false, 'message' => 'Message could not be sent.']);
                    }
                } else {
                    echo json_encode(['status' => 'failure','is_verified' => false, 'message' => 'Failed to update OTP.']);
                }
            }
        } else {
            echo json_encode(['status' => 'failure','is_verified' => false, 'message' => 'Incorrect password.']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failure','is_verified' => false, 'message' => 'Database error.']);
}

function generateOTP() {
    return mt_rand(100000, 999999);
}
?>
