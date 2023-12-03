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

// Function to generate a random OTP
function generateOTP() {
    return mt_rand(100000, 999999);
}

// Get user email from the request
$email = $_POST['email'];

try {
    // Query to retrieve user data by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'failure', 'message' => 'User not found.']);
    } else {
        // Generate a random OTP
        $otp = generateOTP();

        // Update the user's OTP and OTP expiry
        $stmt = $pdo->prepare("UPDATE users SET otp = :otp, otp_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email");
        $stmt->bindParam(':otp', $otp, PDO::PARAM_INT);
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
                $mail->Subject = 'Password Reset OTP';
                $mail->Body    = 'Your OTP for password reset is: ' . $otp;

                $mail->send();

                echo json_encode(['status' => 'success', 'message' => 'OTP sent to your email for password reset.']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'failure', 'message' => 'Message could not be sent.']);
            }
        } else {
            echo json_encode(['status' => 'failure', 'message' => 'Failed to update OTP.']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failure', 'message' => 'Database error.']);
}
?>
