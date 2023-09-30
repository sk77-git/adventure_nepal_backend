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

// Get user email and password from the request
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email is already registered
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo json_encode(['status' => 'failure', 'message' => 'User with this email already exists.']);
    } else {
        // Generate a random OTP
        $otp = generateOTP();

        // Hash the password (you should use a strong hashing algorithm like bcrypt)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query to insert user data into the database
        $stmt = $pdo->prepare("INSERT INTO users (email, password, otp) VALUES (:email, :password, :otp)");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':otp', $otp, PDO::PARAM_INT);

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

                echo json_encode(['status' => 'success', 'message' => 'Registration successful. OTP sent to your email.']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'failure', 'message' => 'Message could not be sent.']);
            }
        } else {
            echo json_encode(['status' => 'failure', 'message' => 'Registration failed.']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failure', 'message' => 'Database error.']);
}
?>
