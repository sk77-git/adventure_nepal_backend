<?php
$host = 'localhost';     
$db_username = 'root'; 
$db_password = ''; 
$db_name = 'adv_nepal';

// Create a database connection using PDO (PHP Data Objects)
try {
    $dsn = "mysql:host=$host;dbname=$db_name";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    );

    // Create the PDO object and connect to the database
    $pdo = new PDO($dsn, $db_username, $db_password, $options);

    // Optional: Set character set to utf8mb4 (if needed)
    $pdo->exec("SET NAMES utf8mb4");
    // echo "Database connection successful";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}




// Now, you can use the $pdo object to execute SQL queries and interact with the database.
// For example:
// $stmt = $pdo->prepare("SELECT * FROM places");
// $stmt->execute();
// $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// ... Process the results ...
